<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessAgreement extends Model
{
    protected $guarded = ['id'];

    public function practice(){
        return $this->belongsTo('App\Practice','practice_id','id');
    }
}
