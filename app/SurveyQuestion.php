<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyQuestion extends Model
{
    protected $guarded =['id'];

    protected $table = 'survey_questions';

    protected $primaryKey ='id';


    public function Survey(){
        return $this->belongsTo('App\Survey');
    }
    
    public function Options(){
        return $this->hasMany('App\QuestionOption',"question_id","id");
    }
}
