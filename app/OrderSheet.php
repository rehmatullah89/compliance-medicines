<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderSheet extends Model
{
	//public $timestamps = false; 
	protected $guarded =['id'];
        protected $table = 'order_sheets';

}
