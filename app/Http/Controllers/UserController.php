<?php

namespace App\Http\Controllers;

use App\Http\Requests\SuggestionRequest;
use App\Suggestions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function getPair() {
        $user = Auth::user();
        $user->hasTaken = 1;
        $user->save();
        return redirect()->route('home');
    }

    public function postSuggestion(SuggestionRequest $request) {
        try {
            DB::beginTransaction();
                if(!Auth::user()->hasSuggestions()) {
                    DB::table('suggestions')->insert([
                        'userId' => Auth::user()->id,
                        'first' => $request->get('first'),
                        'second' => $request->get('second'),
                        'third' => $request->get('third'),
                    ]);
                } else {
                    $suggestions = Suggestions::where('userId', Auth::user()->id)->first();
                    if(!Auth::user()->hasFirstSuggestions()) {
                        $suggestions->first = $request->get('first');
                        $suggestions->save();
                    }
                    if(!Auth::user()->hasSecondSuggestions()) {
                        $suggestions->second = $request->get('second');
                        $suggestions->save();
                    }
                    if(!Auth::user()->hasThirdSuggestions()) {
                        $suggestions->third = $request->get('third');
                        $suggestions->save();
                    }
                }
            DB::commit();
            return redirect()->route('home');
        } catch (\Exceptio $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            DB::rollBack();
        }
        return redirect()->route('home')->with('danger','Wystąpił nieoczekiwany błąd. Spróbuj ponownie.');
    }
}
