<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

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
}
