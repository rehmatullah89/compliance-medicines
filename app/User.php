<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','practice_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function practices() {
        return $this->belongsToMany('App\Practice','practice_user','user_id','practice_id');
    }

    public function userRole() {
        return $this->belongsTo('App\Role','role','id');
    }

    public function roles() {
        return $this->belongsToMany('App\Role', 'model_has_roles', 'model_id', 'role_id');
    }

  public function chats()
{
  return $this->hasMany(Chat::class);
}

public function pharmacyChat(){
    return $this->hasMany(PracticeComplianceadminChat::class,'from','id');
}

public function pharmacySessions(){
    return $this->hasMany(ChatSession::class,'user_id','id');
}


}
