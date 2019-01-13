<?php

namespace App\Http\Controllers;

use App\Mail\Invitation;
use App\Mail\Zaproszenie;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\ShuffledPairs;
use App\Suggestions;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{

    public function shuffle() {
        $users = $this->getUsers();
        $arrNames =[];
        foreach($users as $user) {
            $arrNames[] = $user->name;
        }
        $pairs = [
            'Magdalena' => 'Dariusz',
            'Justyna' => 'Paweł',
            'Barbara' => 'Edward',
            'Beata' => 'Zbigniew',
            'Zdzisław' => 'Grażyna'
        ];
        $shufflePairs = [];
        $lostNames = [];
        for($i=0; $i<count($arrNames); $i++) {
            do {
                $chosenName = $this->getRandomName($arrNames);
                $number = 0;
                foreach($pairs as $name1 => $name2) {
                    if([$chosenName => $arrNames[$i]] == [$name1 => $name2] || [$chosenName => $arrNames[$i]] == [$name2 => $name1]) {
                        $number = 1;
                        continue;
                    }
                }
            } while($chosenName == $arrNames[$i] || in_array($chosenName,$lostNames) || $number == 1);

            $shufflePairs[$arrNames[$i]] = $chosenName;
            $lostNames[] = $shufflePairs[$arrNames[$i]];
        }

        try {
            DB::beginTransaction();
            ShuffledPairs::truncate();
            Suggestions::truncate();
            foreach ($shufflePairs as $name1 => $name2) {
                $hashName = Crypt::encryptString($name2);
                DB::table('shuffled_pairs')->insert(['Osoba_kupująca' => $name1, 'Osoba_wylosowana' => $hashName]);
            }
            $users = $this->getUsers();
            foreach ($users as $user) {
                $user->hasTaken = 0;
                $user->save();
            }
            DB::commit();
            return redirect()->route('home')->with('success','Pomyślnie przetasowano');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            DB::rollBack();
        }
        return redirect()->route('home')->with('danger','Wystąpił nieoczekiwany błąd. Spróbuj ponownie.');

    }

    public function getRandomName($arrNames) {
        $nameToBuy = $arrNames[rand(0, count($arrNames)-1)];
            return $nameToBuy;
    }

    public function getUsers() {
        return User::all();
    }

    public function delete() {
        try {
            DB::beginTransaction();
            ShuffledPairs::truncate();
            Suggestions::truncate();
            $users = $this->getUsers();
            foreach ($users as $user) {
                $user->hasTaken = 0;
                $user->save();
            }
            DB::commit();
            return redirect()->route('home')->with('success','Pomyślnie wszystko usunięto');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            DB::rollBack();
        }
        return redirect()->route('home')->with('danger','Wystąpił nieoczekiwany błąd. Spróbuj ponownie.');
    }

    public function sendMailPairs() {
        $users = $this->getUsers();
        $url = 'https://' . $_SERVER['HTTP_HOST'];
        foreach ($users as $user) {
            Mail::to($user->email)->send(new Zaproszenie($url));
        }
        return redirect()->route('home')->with('success','Pomyślnie wysłano maile');
    }
}
