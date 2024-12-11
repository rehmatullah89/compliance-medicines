<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "Orders";
    protected $guarded = ['Id'];
    protected $primaryKey = "Id";

    public function orderStatus()
    {
        return $this->belongsTo('App\OrderStatus');
    }

    public function patient()
    {
        return $this->belongsTo('App\Patient','PatientId','Id');
    }
    
    public function payment_recived()
    {
        return $this->belongsTo('App\Payment_recived','Id','order_id');
    }

    public function statuslogs()
    {
        return $this->hasMany('App\OrderStatusLog','order_id','Id');
    }
    
    public function practice()
    {
        return $this->belongsTo('App\Practice','PracticeId','id');
    }

    public function drug()
    {
        return $this->belongsTo('App\Drug','DrugDetailId','id');
    }

    public function setRxNumberAttribute($value)
    {
        $this->attributes['RxNumber'] = strtoupper($value);
    }

      /*public function Survey(){
        return $this->hasMany('App\Survey');
    }*/

}
