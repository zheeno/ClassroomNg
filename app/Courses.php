<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    public function classes(){
        return $this->hasMany('App\classes', 'course_id')->where("status", "APPROVED")->orderBy('id', 'DESC');
    }
    public function rejectedClasses(){
        return $this->hasMany('App\classes', 'course_id')->where("status", "REJECTED")->orderBy('id', 'DESC');
    }
    public function pendingClasses(){
        return $this->hasMany('App\classes', 'course_id')->where("status", "PENDING")->orderBy('id', 'DESC');
    }
    public function allClasses(){
        return $this->hasMany('App\classes', 'course_id')->orderBy('id', 'DESC');
    }
    public function subscription(){
        return $this->hasMany('App\subscriptions', 'course_id')->orderBy('id', 'DESC');
    }
}
