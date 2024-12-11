<?php


namespace App;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table = 'model_has_roles';
    
    /*public function users() {
        return $this->belongsToMany('App\User','model_id','id');
    }
    
    public function roles() {
        return $this->belongsToMany('App\Role','role_id','id');
    }*/
}
