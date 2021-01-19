<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocalService extends Model
{
    protected $table = 'local_service';

    public function local(){
        return $this->belongsTo('App\Local', 'local_id');
    }

    public function service(){
        return $this->belongsTo('App\Service', 'service_id');
    }
}
