<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ShuffledPairs;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getPair() {
        $user = Auth::user();
        $user->hasTaken = 1;
        $user->save();
        return redirect()->back();
    }
}
