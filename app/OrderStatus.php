<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
   protected $table = "OrderStatus";
    protected $primaryKey = "Id";

    protected function ordersStatus(){
        return $this->hasMany('App/Order');
    }

}
