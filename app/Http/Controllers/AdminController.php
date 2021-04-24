<?php

namespace App\Http\Controllers;

use App\History;
use App\Http\Requests\ChangeBirthdayRequest;
use App\Http\Requests\ChangeMailRequest;
use App\Mail\Invitation;
use App\Mail\SecondMail;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\ShuffledPairs;
use App\Suggestions;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{

    public function addUser() {
        return route('register');
    }

    public function shuffle() {
        $shufflePairs = $this->shufflePairsToLottery();
        try {
            DB::beginTransaction();
            ShuffledPairs::truncate();
            Suggestions::truncate();
            foreach ($shufflePairs as $name1 => $name2) {
                $hashName = Crypt::encryptString($name2);
                DB::table('shuffled_pairs')->insert(['Osoba_kupująca' => $name1, 'Osoba_wylosowana' => $hashName]);
            }
            foreach (User::all() as $user) {
                $user->hasTaken = 0;
                $user->save();
            }
            DB::commit();
            return redirect()->back()->with('success','Pomyślnie przetasowano');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            DB::rollBack();
        }
        return redirect()->back()->with('danger','Wystąpił nieoczekiwany błąd. Spróbuj ponownie.');

    }

    public function getRandomName($arrNames) {
        return $arrNames[rand(0, count($arrNames)-1)];
    }

    public function resetShuffle() {
        try {
            DB::beginTransaction();
            ShuffledPairs::truncate();
            Suggestions::truncate();
            foreach (User::where('roles', '!=', 'child')->get() as $user) {
                $user->hasTaken = 0;
                $user->save();
            }
            DB::commit();
            return redirect()->back()->with('success','Pomyślnie zresetowano losowanie');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            DB::rollBack();
        }
        return redirect()->back()->with('danger','Wystąpił nieoczekiwany błąd. Spróbuj ponownie.');
    }

    public function deleteUser($id) {
        $user = User::find($id);
        if($user->canTakeName()) {
            return redirect()->route('users')->with('danger','Możesz usunąć uczestnika tylko wtedy, gdy losowanie jest zresetowane');
        }
        $user->delete();
        return redirect()->route('users')->with('success','Użytkownik został usunięty');
    }

    public function deleteChildren($id) {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('children')->with('success','Dzieciak został usunięty');
    }

    public function sendMailPairs($id = null) {
        if($id) {
            $user = User::find($id);
            if($user->logged == null) {
                Mail::to($user->email)->send(new Invitation());
            } else {
                Mail::to($user->email)->send(new SecondMail());
            }

            return redirect()->back()->with('success','Pomyślnie wysłano e-mail do tego uczestnika');
        }
        foreach (User::whereIn('roles', ['superadmin', 'admin', 'user'])->get() as $user) {
            if($user->logged == null) {
                Mail::to($user->email)->send(new Invitation());
            } else {
                Mail::to($user->email)->send(new SecondMail());
            }
        }
        return redirect()->back()->with('success','Pomyślnie wysłano maile');
    }

    public function saveEditUser(ChangeMailRequest $request, $id) {
        User::find($id)->update(['email' => $request->get('email')]);
        return redirect()->route('users')->with('success','Pomyślnie edytowano adres e-mail');
    }

    public function saveEditUserBirthday(ChangeBirthdayRequest $request, $id) {
        User::find($id)->update(['birthday' => $request->get('birthday')]);
        return redirect()->route('children')->with('success','Pomyślnie edytowano urodziny dzieciaka');
    }

    public function doAdmin($id) {
        User::find($id)->update(['roles' => 'admin']);
        return redirect()->route('users')->with('success','Pomyślnie nadano użytkownikowi rolę admina');
    }

    public function deleteAdmin($id) {
        User::find($id)->update(['roles' => null]);
        return redirect()->route('users')->with('success','Pomyślnie usunięto użytkownikowi rolę admina');
    }

    public function checkPair($name, $chosenName, $pairs) {
        if($name == $chosenName) {
            return false;
        }

        $myPairs = [];
        foreach ($pairs as $arrPair) {
            if(isset($arrPair[$name])) {
                $myPairs[] = $arrPair;
            }
        }

        foreach ($myPairs as $arrPair) {
            if($arrPair[$name] == $chosenName) {
                return false;
            }
        }
        return true;
    }

    public function shufflePairsToLottery() {
        $pairs = [
            ['Magdalena' => 'Dariusz'],
            ['Justyna' => 'Paweł'],
            ['Barbara' => 'Edward'],
            ['Beata' => 'Zbigniew'],
            ['Zdzisław' => 'Grażyna'],
            ['Damian' => 'Joanna'],
            ['Dariusz' => 'Magdalena'],
            ['Paweł' => 'Justyna'],
            ['Edward' => 'Barbara'],
            ['Zbigniew' => 'Beata'],
            ['Grażyna' => 'Zdzisław'],
            ['Joanna' => 'Damian']
        ];
        $lastYearHistory = History::select('name', 'pair')
            ->where('year',date('Y')-1)
            ->get()
            ->toArray();
        foreach ($lastYearHistory as $arrPair) {
            $pairs[] = [$arrPair['name'] => $arrPair['pair']];
        }

        $arrNames =[];
        foreach(User::whereIn('roles', ['superadmin', 'admin', 'user'])->get() as $user) {
            $arrNames[] = $user->name;
        }
        $arrReturn = [];
        $shufflePairs = [];
        for($q=0; $q<10;$q++) {
            $shufflePairs = [];
            $lostNames = $arrNames;
            for($i=0; $i<count($arrNames); $i++) {
                $intWhile = 0;
                do {
                    $chosenName = $this->getRandomName($lostNames);
                    $intWhile++;
                    if($intWhile > 1000){
                        continue 3;
                    }
                } while (!$this->checkPair($arrNames[$i], $chosenName, $pairs));
                $shufflePairs[$arrNames[$i]] = $chosenName;
                if (($key = array_search($chosenName, $lostNames)) !== false) {
                    unset($lostNames[$key]);
                }
                $lostNames = array_values($lostNames);
            }

            foreach ($shufflePairs as $name => $chosenName){
                if(isset($arrReturn[$name][$chosenName])){
                    $arrReturn[$name][$chosenName]++;
                }else {
                    $arrReturn[$name][$chosenName] = 1;
                }
            }
        }
        return $shufflePairs;
    }

    public function superShuffle() {
        $shufflePairs = $this->shufflePairsToLottery();
        dd($shufflePairs);
    }

    public function showChildren() {
        $children = User::where('roles','child')->get();
        return view('admin.children', compact('children'));
    }

    public function saveHistory() {
        if(date('m') == 12) {
            $year = date('Y');
        } else {
            $year = date('Y')-1;
        }
        $pairs = ShuffledPairs::all();

        if(History::where('year', $year)->first()) {
            return redirect()->route('history')->with('danger', 'Losowanie z tego roku już jest zapisane');
        }

        try {
            DB::beginTransaction();
            foreach ($pairs as $pair) {
                $history = new History();
                $realPair = Crypt::decryptString($pair->Osoba_wylosowana);

                $history->year = $year;
                $history->name = $pair->Osoba_kupująca;
                $history->pair = $realPair;
                $history->save();
            }
            DB::commit();
            return redirect()->route('history')->with('success', 'Poprawnie zapisano historię losowania');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            DB::rollBack();
        }
        return redirect()->back()->with('danger','Wystąpił nieoczekiwany błąd. Spróbuj ponownie.');
    }
}
