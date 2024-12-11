<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionOption extends Model
{
    protected $guarded =['id'];

    protected $table = 'survey_question_options';

    protected $primaryKey ='id';


    /*public function Survey(){
        return $this->hasMany('App\Survey');
    }*/
}
