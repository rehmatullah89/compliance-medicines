<?php

namespace App;

use App\Traits\Encryptable;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{

    use Encryptable;

    protected $encryptable = [
        'MobileNumber',
        'FirstName',
        'LastName',
        'EmailAddress',
        'BirthDate',
        'PaymentSignature'
    ];

    protected $table="PatientProfileInfo";
    protected $primaryKey="Id";
    protected $guarded =['Id'];

    public function enrollment(){
        return $this->hasOne('App\Enrollment','patient_id','Id');
    }

    public function orders(){
        return $this->hasMany('App\Order','PatientId','Id');
    }

    public function practice(){
        return $this->belongsTo('App\Practice','Practice_ID','id');
    }
}
