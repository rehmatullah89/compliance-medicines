<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankDetail extends Model
{

    protected $guarded = ['id'];

    public function practice()
    {
        return $this->belongsTo('App\Practice');
    }
}
