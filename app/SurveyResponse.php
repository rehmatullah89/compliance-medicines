<?php

namespace App;

use App\SurveyResponseDetail;
use Illuminate\Database\Eloquent\Model;

class SurveyResponse extends Model
{
    protected $guarded =['id'];

    protected $table = 'survey_response';

    protected $primaryKey ='id';


    public function Survey(){
        return $this->belongsTo('App\Survey');
    }
    
    public function Details(){
        return $this->hasMany('App\SurveyResponseDetail');
    }
}
