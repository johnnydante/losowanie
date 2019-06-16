<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        $user->logged++;
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
    }
}
