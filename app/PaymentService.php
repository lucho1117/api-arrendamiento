<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentService extends Model
{
    protected $table = 'payment_service';

    public function payment(){
        return $this->belongsTo('App\LocalService', 'local_service_id');
    }

    public function Card(){
        return $this->belongsTo('App\CardType', 'card_type_id');
    }
}
