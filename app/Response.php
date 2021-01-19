<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    protected $table = 'response';

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }
}
