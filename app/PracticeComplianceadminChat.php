<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PracticeComplianceadminChat extends Model
{
   
   protected $table = 'practice_complianceadmin_chats';
    protected $guarded = ['id'];

    public function fromContact()
    {
        return $this->hasOne(User::class, 'id', 'from');
    }
    
}
