<?php

namespace App\Http\Controllers\Cron;

use App\Mail\Birthday;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BirthdayMailController extends Controller
{
    protected $users = [];

    public function send() {
        $users = User::all();

        foreach($users as $user) {
            if(\Globals::getDateToDiff($user->birthday) == date('Y-m-d')) {
                $this->users[] = $user;
            }
        }
        if(count($this->users) > 0) {
            foreach ($this->users as $user) {
                $mailUsers = User::where('roles', '!=', 'child')
                    ->whereNotIn('name', [$user->name, 'Darek', 'Magda'])
                    ->get();

//            $mailUsers = User::where('role', 'superadmin')->get();
                try {
                    foreach ($mailUsers as $mailUser) {
                        Mail::to($mailUser->email)->send(new Birthday($user->name));
                    }
                    Log::debug('Poszły maile o urudzinach uczestnika: '.$user->name);
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                    Log::error($e->getTraceAsString());
                }
            }
        }
    }
}
