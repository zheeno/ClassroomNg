<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class classes extends Model
{
    public function course(){
        return $this->belongsTo('App\Courses');
    }
    
    public function instructor(){
        return $this->belongsTo('App\User', 'instructor_id');
    }

    public function students(){
        return $this->hasMany('App\subscriptions', 'class_id')->orderBy('id', 'DESC');
    }
    
    public function comments(){
        return $this->hasMany('App\Comments', 'class_id')->orderBy('id', 'DESC');
    }

    public function attachments(){
        return $this->hasMany('App\attachments', 'class_id')->orderBy('id', 'ASC');
    }

    public function reviews(){
        return $this->hasMany('App\Reviews', 'class_id')->orderBy('id', 'DESC');
    }
    
    public function reviewsWithoutAuthResponse(){
        return $this->hasMany('App\Reviews', 'class_id')->where("receiver_id", "!=", null)->orderBy('id', 'DESC');
    }
}
