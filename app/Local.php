<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    protected $table = 'local';

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function sector(){
        return $this->belongsTo('App\Sector', 'sector_id');
    }

    public function prueba() {
    }
}
