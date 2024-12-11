<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyResponseDetail extends Model
{
    protected $guarded =['id'];

    protected $table = 'survey_response_detail';

    protected $primaryKey ='id';


    /*public function Survey(){
        return $this->hasMany('App\Survey');
    }*/
}
