<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    public $timestamps = false;

    protected $table = 'history';

    protected $fillable = [
        'year', 'name', 'pair'
    ];
}
