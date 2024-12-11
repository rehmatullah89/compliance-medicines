<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
     protected $guarded =['id'];

    protected $primaryKey ='id';


     public function practice() {
        return $this->belongsTo('App\Practice');
    }
}
