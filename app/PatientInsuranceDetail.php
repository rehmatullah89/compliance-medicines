<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Encryptable;

class PatientInsuranceDetail extends Model
{
    //
    protected $primaryKey = "Id";
    protected $table='PatientInsuranceDetails';
    public $timestamps  = false;
    use Encryptable;

    protected $encryptable = [
        'InsuranceFrontCardPath',
        'InsuranceBackCardPath'
    ];
}
