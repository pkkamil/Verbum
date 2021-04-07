<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Remembered extends Model
{
    public $timestamps = false;
    protected $dates = ['remembered_at'];
    protected $table = 'user_word';
}
