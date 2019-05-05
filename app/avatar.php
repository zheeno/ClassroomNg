<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class avatar extends Model
{
    //
    public function users(){
        return $this->hasMany('App\Users', 'user_id')->orderBy('id', 'DESC');
    }
}
