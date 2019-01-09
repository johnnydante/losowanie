<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShuffledPairs extends Model
{
    protected $fillable = [
        'Osoba kupująca', 'Osoba wylosowana'
    ];
}
