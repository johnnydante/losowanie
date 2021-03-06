<?php

namespace App\Http\Controllers;

use App\History;
use App\Http\Requests\DatasRequest;
use App\Http\Requests\SuggestionRequest;
use App\ShuffledPairs;
use App\Suggestions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserController extends Controller
{

    public function users() {
        return view('admin.users')->with('users',User::whereIn('roles', ['superadmin', 'admin', 'user'])->get());
    }

    public function birthdays() {
        return view('birthdays')->with('users',User::orderBy('daysToBirthday')->get());
    }

    public function getPair() {
        $user = Auth::user();
        $user->hasTaken = 1;
        $user->save();
        return redirect()->route('home');
    }

    public function postSuggestion(SuggestionRequest $request) {
        try {
            DB::beginTransaction();
                if(!Suggestions::where('userId', Auth::user()->id)->first()) {
                    DB::table('suggestions')->insert([
                        'userId' => Auth::user()->id
                    ]);
                }
                $suggestions = Suggestions::where('userId', Auth::user()->id)->first();
                if(!Auth::user()->hasFirstSuggestions()) {
                    $suggestions->first = $request->get('first');
                    $suggestions->save();
                }
                if(!Auth::user()->hasSecondSuggestions()) {
                    if(!Auth::user()->hasFirstSuggestions()) {
                        $suggestions->first = $request->get('second');
                        $suggestions->save();
                    } else {
                        $suggestions->second = $request->get('second');
                        $suggestions->save();
                    }

                }
                if(!Auth::user()->hasThirdSuggestions()) {
                    if(!Auth::user()->hasFirstSuggestions()) {
                        $suggestions->first = $request->get('third');
                        $suggestions->save();
                    } elseif(!Auth::user()->hasSecondSuggestions()) {
                        $suggestions->second = $request->get('third');
                        $suggestions->save();
                    } else {
                        $suggestions->third = $request->get('third');
                        $suggestions->save();
                    }
                }
            DB::commit();
            return redirect()->route('home');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            DB::rollBack();
        }
        return redirect()->route('home')->with('danger','Wystąpił nieoczekiwany błąd. Spróbuj ponownie.');
    }

	public function changeSuggestion($suggest) {
		$user = Auth::user();
		$oldSuggestion = DB::table('suggestions')->where('userId', $user->id)->first()->$suggest;
		DB::table('suggestions')->where('userId', $user->id)->update([$suggest => null]);
		if(!Auth::user()->hasFirstSuggestions()) {
            if(Auth::user()->hasSecondSuggestions()) {
                DB::table('suggestions')->where('userId', $user->id)->update(['first' => $user->getMySecondSuggestion()]);
                DB::table('suggestions')->where('userId', $user->id)->update(['second' => null]);
                if(Auth::user()->hasThirdSuggestions()) {
                    DB::table('suggestions')->where('userId', $user->id)->update(['second' => $user->getMyThirdSuggestion()]);
                    DB::table('suggestions')->where('userId', $user->id)->update(['third' => null]);
                }
            } else {
                if(Auth::user()->hasThirdSuggestions()) {
                    DB::table('suggestions')->where('userId', $user->id)->update(['second' => $user->getMyThirdSuggestion()]);
                    DB::table('suggestions')->where('userId', $user->id)->update(['third' => null]);
                }
            }
        } else {
            if(!Auth::user()->hasSecondSuggestions()) {
                DB::table('suggestions')->where('userId', $user->id)->update(['second' => $user->getMyThirdSuggestion()]);
                DB::table('suggestions')->where('userId', $user->id)->update(['third' => null]);
            }
        }
		return redirect()->route('home')->with('oldSuggestion', $oldSuggestion);
	}

	public function changePasswordShow() {
		return view('auth.changePassword');
	}

	public function changePasswordPost(ChangePasswordRequest $request) {
		$myPassword = Auth::user()->password;
		if (Hash::check($request->get('oldPassword'), $myPassword)) {
			$user = Auth::user();
			$user->password = Hash::make($request->get('password'));
			$user->logged++;
			$user->save();
		} else {
			return redirect()->back()->with('danger', 'Stare hasło nie jest poprawne');
		}
		return redirect()->route('home')->with('success', 'Hasło zostało zmienione');
	}

    public function myDatasShow() {
        return view('auth.myDatas');
    }

    public function changeDatasShow() {
        return view('auth.changeDatas');
    }

    public function myDatasPost(DatasRequest $request) {
        $user = Auth::user();
        $user->email = $request->get('email');
        $user->name = $request->get('name');
        $user->birthday = $request->get('birthday');
        $user->save();
        $year = date('Y')+1;
        foreach (User::all() as $user) {
            if(\Globals::getDateToDiff($user->birthday) > date('Y-m-d')) {
                $intDiff = date_diff(date_create(\Globals::getDateToDiff($user->birthday)),date_create(date('Y-m-d')))->days;
            } elseif($user->birthday == null) {
                $intDiff = 444;
            }else {
                if($year % 4 == 0 && $year % 100 != 0 || $year % 400 == 0) {
                    $intDiff = 366 - date_diff(date_create(\Globals::getDateToDiff($user->birthday)),date_create(date('Y-m-d')))->days;
                } else {
                    $intDiff = 365 - date_diff(date_create(\Globals::getDateToDiff($user->birthday)),date_create(date('Y-m-d')))->days;
                }
            }
            if(($intDiff == 365 AND !($year % 4 == 0 && $year % 100 != 0 || $year % 400 == 0)) OR ($intDiff == 366 AND ($year % 4 == 0 && $year % 100 != 0 || $year % 400 == 0))) {
                $user->daysToBirthday = 0;
            } else {
                $user->daysToBirthday = $intDiff;
            }
            $user->save();
        }
        return redirect()->route('myDatas')->with('success', 'Dane zostały poprawnie zmienione');
    }

    public function history() {
        $years = History::orderBy('year', 'desc')->groupBy('year')->pluck('year');
        return view('auth.history')
            ->with('years',$years);
    }
}
