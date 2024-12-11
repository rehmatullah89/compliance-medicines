<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Drug extends Model
{
    use SoftDeletes;
    
    protected $guarded =['id'];

    protected $table = 'drugs_new';

    protected $primaryKey ='id';


    public function order(){
        return $this->hasMany('App\Order','DrugDetailId','id');
    }
    /*public function Survey(){
        return $this->hasMany('App\Survey');
    }*/
}
