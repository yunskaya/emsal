<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';

    protected $fillable  = [
        'user_name',
        'user_id',
        'message'
    ];
}
