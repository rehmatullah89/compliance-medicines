<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $guarded =['id'];

    protected $table = 'messages';

    protected $primaryKey ='id';
}
