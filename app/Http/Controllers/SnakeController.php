<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;

class SnakeController extends Controller
{
    public function index() {
        $highScore = Auth::user()->getSnakeScore();
        return view('snake')->with('highScore', $highScore);
    }

    public function save (Request $request) {
        User::where('id', Auth::user()->id)->update(['points' => $request->get('highScore')]);
        return redirect()->back()->with('success', 'Pomyślnie zapisano Twój Rekord do bazy danych');
    }

    public function ranking() {
        $users = User::whereIn('roles', ['superadmin', 'admin', 'user'])->orderBy('points', 'desc')->get();

        return view('ranking')->with(compact('users'));
    }
}
