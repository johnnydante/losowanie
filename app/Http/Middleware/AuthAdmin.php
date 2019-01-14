<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthAdmin
{
    protected $arrRolesWithAccess = [
        'admin'
    ];

    public function handle($request, Closure $next) {
        if(Auth::user()) {
            if(in_array(Auth::user()->roles, $this->arrRolesWithAccess)) {
                return $next($request);
            }
            return Auth::user()->redirectNoAccess();
        }
        return route('home');
    }
}
