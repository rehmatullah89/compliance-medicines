<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatientProfile extends Model
{
    protected $guarded =['id'];

    protected $table = 'PatientProfileInfo';

    protected $primaryKey ='id';


    public function Practice(){
        return $this->belongsTo('App\Practice', "Practice_ID", "id");
    }
}
