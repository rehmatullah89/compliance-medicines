<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $guarded = ['id'];


    public function practices(){
    	return $this->hasMany('App\Practice','group_id','id');
    }
    public function users()
    {
    	return $this->hasMany('App\User');
    }
}
