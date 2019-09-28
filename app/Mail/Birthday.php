<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Birthday extends Mailable
{
    use Queueable, SerializesModels;

    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function build()
    {
        return $this->from('rodzinne.losowanie@gmail.com')
                    ->subject($this->name.' ma urodziny!')
                    ->markdown('emails.birthday', ['name' => $this->name]);
    }
}
