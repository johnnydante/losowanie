<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ShufflingController extends Controller
{
    public function shuffle() {

    }

    public function users() {
        $users = User::all();
        dd($users);
        return $users;
    }
}
