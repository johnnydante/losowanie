<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

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
            'Beata' => 'Zbigniew'
        ];
        $shufflePairs = [];
        $lostNames = [];
        for($i=0; $i<count($arrNames); $i++) {
            $shufflePairs[$i] = [$arrNames[$i] => $this->getRandomName($arrNames, $arrNames[$i], $lostNames)];
            $lostNames[] = $shufflePairs[$i][$arrNames[$i]];
        }
        dd($shufflePairs, $lostNames);


        return redirect()->back()->with('Przetasowano pomyślnie');
    }

    public function getRandomName($arrNames, $name, $lostNames) {
        $nameToBuy = $arrNames[rand(0, count($arrNames)-1)];
        if($nameToBuy == $name || in_array($nameToBuy,$lostNames)) {
            $this->getRandomName($arrNames, $name, $lostNames);
        }
        return $nameToBuy;
    }

    public function getUsers() {
        return User::all();
    }
}
