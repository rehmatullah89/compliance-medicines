<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderSheetCategory extends Model
{
	//public $timestamps = false; 
	protected $guarded =['id'];
        protected $table = 'order_sheet_categories';

}
