<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trash extends Model
{
    public $timestamps = false;
    protected $dates = ['added_at'];
    protected $table = 'trash';
}
