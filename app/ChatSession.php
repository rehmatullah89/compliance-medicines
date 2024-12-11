<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatSession extends Model
{
    protected $table = 'practice_compliacneadmin_session';
    protected $primary_key = 'id';
    protected $guarded = ['id'];


    protected function user(){
        return $this->belongsTo(User::class);
    }
}
