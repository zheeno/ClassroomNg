<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class subscriptions extends Model
{
    public function course(){
        return $this->belongsTo('App\Courses');
    }
    
    public function student(){
        return $this->belongsTo('App\User', 'id');
    }

    public function instructor(){
        return $this->belongsTo('App\User');
    }
}
