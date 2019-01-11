<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use App\ShuffledPairs;
use Illuminate\Support\Facades\Crypt;
use App\Suggestions;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAdmin() {
        if(Auth::user()->roles == 'admin') {
            return true;
        }
        return false;
    }

    public function redirectNoAccess() {
        return redirect('/')->with(
            'danger', 'Brak dostepu do tego zasobu.'
        );
    }

    public function hasTaken() {
        if(Auth::user()->hasTaken == 1) {
            return true;
        }
        return false;
    }

    public function canTakeName() {
        $shuffledPairs = ShuffledPairs::all();
        if(count($shuffledPairs) > 0) {
            return true;
        }
        return false;
    }

    public function getMyPair() {
        $hashPair = ShuffledPairs::where('Osoba_kupująca', Auth::user()->name)->first()->Osoba_wylosowana;
        $myPair = Crypt::decryptString($hashPair);
        return $myPair;
    }
	
	public function getUserIdByName($name) {
		$id = DB::table('users')->where('name', $name)->first()->id;
		return $id;
	}

		public function getMyPairSuggestions() {
		$myPair = $this->getMyPair();
		$myPairSuggestions = DB::table('suggestions')->where('userId', $this->getUserIdByName($myPair))->first();
		return $myPairSuggestions;
	}

    public function getSuggestions() {
        return Suggestions::where('userId', Auth::user()->id)->first();
    }

    public function hasSuggestions() {
        if($this->getSuggestions()) {
            return true;
        }
        return false;
    }

    public function hasFirstSuggestions() {
        if($this->getSuggestions()['first']) {
            return true;
        }
        return false;
    }

    public function hasSecondSuggestions() {
        if($this->getSuggestions()['second']) {
            return true;
        }
        return false;
    }

    public function hasThirdSuggestions() {
        if($this->getSuggestions()['third']) {
            return true;
        }
        return false;
    }

    public function getMyFirstSuggestion() {
        $first = $this->getSuggestions()['first'];
        return $first;
    }

    public function getMySecondSuggestion() {
        $second = $this->getSuggestions()['second'];
        return $second;
    }

    public function getMyThirdSuggestion() {
        $third = $this->getSuggestions()['third'];
        return $third;
    }

    public function hasAllSuggestions() {
        if($this->hasFirstSuggestions() && $this->hasSecondSuggestions() && $this->hasThirdSuggestions()) {
            return true;
        }
        return false;
    }
}
