<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{

    protected $guarded =['id'];

    protected $table = 'surveys';

    protected $primaryKey ='id';


    public function Questions(){
        return $this->hasMany('App\SurveyQuestion');
    }
    
    public function User(){
        return $this->belongsTo('App\User', "user_id", "id");
    }
    
    public function Category(){
        return $this->belongsTo('App\SurveyCategory', "category_id", "id");
    }
    
    public function Theme(){
        return $this->hasOne('App\SurveyTheme', "survey_id", "id");
    }

}
