<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment_recived extends Model
{
    protected $guarded =['id'];

    protected $table = 'payment_recived';

    protected $primaryKey ='id';


    public function order(){
        return $this->hasMany('App\Order','order_id','Id');
    }
}
