<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionAnswer extends Model
{
    //
    protected $primaryKey = "Id";
    protected $table='QuestionAnswer';
    public $timestamps  = false;
}
