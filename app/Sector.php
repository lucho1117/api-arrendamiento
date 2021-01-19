<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    protected $table = 'sector';
    //

    public function local()
  {
    return $this->hasMany('App\Local');
  }
}
