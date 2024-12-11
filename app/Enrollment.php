<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $guarded =['id'];

    public function patient(){
        $this->belongsTo('App\Patient');
    }
}
