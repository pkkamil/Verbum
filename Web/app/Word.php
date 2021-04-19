<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    public function remembered_by() {
        return $this->belongsToMany('App\User');
    }
}
