<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class assignedTo extends Model
{
    public function course(){
        return $this->belongsTo('App\Courses');
    }
}
