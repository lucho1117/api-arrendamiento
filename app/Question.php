<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'question';

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

}
