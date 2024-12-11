<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyTheme extends Model
{
    protected $guarded =['id'];

    protected $table = 'survey_themes';

    protected $primaryKey ='id';


    /*public function Survey(){
        return $this->belongsTo('App\Survey');
    }*/
}
