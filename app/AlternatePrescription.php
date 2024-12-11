<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlternatePrescription extends Model
{
	public $timestamps = false; 
	protected $guarded =['id'];
    protected $table = 'alternate_prescriptions';

}
