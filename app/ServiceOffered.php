<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceOffered extends Model
{
    //
    protected $table='services_offered';

    protected $fillable=['service_title','service_choice'];

    public function practice()
    {
    	return $this->belongsTo('App\Practice');
    }
}
