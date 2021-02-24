<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'type', 'score', 'user_id',
    ];
}
