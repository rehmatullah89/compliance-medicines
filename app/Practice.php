<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Practice extends Model
{
    protected $guarded = ['id'];

    public function bankDetail() {
        return $this->hasOne('App\BankDetail');
    }

    public function users() {
        return $this->belongsToMany('App\User','practice_user','practice_id','user_id');
    }

    public function services() {
        return $this->hasMany('App\Service');
    }

    public function orders(){
        return $this->hasMany('App\Order','PracticeId','id');
    }

    public function patients(){
        return $this->hasMany('App\Patient','Practice_ID','id');
    }

    public function services_offered()
    {
        return $this->hasMany('App\ServiceOffered');
    }
    
    public function order_sheet()
    {
        return $this->hasMany('App\OrderSheet');
    }
     /*public function Survey(){
        return $this->hasMany('App\Survey');
    }*/

    public function group(){
        return $this->belongsTo('App\Group','group_id','id');
    }
    
    public function createdBy(){
        return $this->belongsTo('App\User', 'created_by_user', 'id');
    }

    public function businessAgreement(){
        return $this->hasOne('App\BusinessAgreement','practice_id','id');
    }
}
