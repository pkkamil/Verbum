<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    public $timestamps = false;
    protected $dates = ['added_at'];
}
