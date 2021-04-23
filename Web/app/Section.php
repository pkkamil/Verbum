<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    public function words() {
        return $this->hasMany('App\SectionElement');
    }
}
