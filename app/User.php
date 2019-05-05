<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'permission'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function myAvatar(){
        return $this->hasMany('App\avatar');
    }
    // get a list of courses which a student subscribed to
    public function courseList(){
        return $this->hasMany('App\subscriptions', 'student_id')->where('course_id', '!=', null)->orderBy('id', 'DESC');
    }
    
    // get courses assigned to a moderator
    public function assignedCourses(){
        return $this->hasMany('App\assignedTo', 'moderator_id')->where('course_id', '!=', null)->orderBy('id', 'DESC');
    }

    // get list of instructor which a student subscribed to
    public function instructorSubscription(){
        return $this->hasMany('App\subscriptions', 'student_id')->where('instructor_id', '!=', null)->orderBy('id', 'DESC');
    }
    // get list of unread notifications for an instructor
    public function unreadNotifs(){
        return $this->hasMany('App\Reviews', 'receiver_id')->where('seen', false)->orderBy('id', 'DESC');
    }
    // get followers for instructor who is logged in
    public function myFollowers(){
        return $this->hasMany('App\subscriptions', 'instructor_id')->orderBy('id', 'DESC');
    }
    // get classes created by a logged in instructor
    public function myClasses(){
        return $this->hasMany('App\classes', 'instructor_id')->orderBy('id', 'DESC');
    }


    // for middlewares
    public function isAdmin(){
        if($this->permission == 755){
            return true;
        }else{
            return false;
        }
    }
    public function isModerator(){
        if($this->permission == 702){
            return true;
        }else{
            return false;
        }
    }
    public function isInstructor(){
        if($this->permission == 701){
            return true;
        }else{
            return false;
        }
    }
    public function isStudent(){
        if($this->permission == 700){
            return true;
        }else{
            return false;
        }
    }
}
