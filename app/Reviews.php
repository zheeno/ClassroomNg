<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    public function moderator(){
        return $this->belongsTo('App\User', "moderator_id");
    }
}
