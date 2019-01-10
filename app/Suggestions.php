<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suggestions extends Model
{
    protected $fillable = [
        'userId', 'first', 'second', 'third'
    ];
}
