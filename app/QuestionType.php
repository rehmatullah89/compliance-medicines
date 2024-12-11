<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionType extends Model
{
    protected $guarded =['id'];

    protected $table = 'survey_question_types';

    protected $primaryKey ='id';


    /*public function Survey(){
        return $this->hasMany('App\Survey');
    }*/
}
