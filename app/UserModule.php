<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserModule extends Model
{
    protected $table = 'user_module';


    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function module(){
        return $this->belongsTo('App\Module', 'module_id');
    }

}
