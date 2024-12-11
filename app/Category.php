<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded =['id'];

    protected $table = 'survey_category';

    protected $primaryKey ='id';


    /*public function Survey(){
        return $this->hasMany('App\Survey');
    }*/
}
