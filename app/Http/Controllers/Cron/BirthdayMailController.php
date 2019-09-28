<?php

namespace App\Http\Controllers\Cron;

use App\Mail\Birthday;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BirthdayMailController extends Controller
{
    protected $user = null;

    public function send() {
        $users = User::all();
        foreach($users as $user) {
            if(\Globals::getDateToDiff($user->birthday) == date('Y-m-d')) {
                $this->user = $user;
            }
        }
        if($this->user) {
            $mailUsers = User::where('roles', '!=', 'child')
                ->whereNotIn('name', [$this->user->name])
                ->get();
            try {
                foreach ($mailUsers as $user) {
                    Mail::to($user->email)->send(new Birthday($this->user->name));
                }
                dd('poszło');
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                Log::error($e->getTraceAsString());
                dd('nie poszło');
            }
        }
    }
}
