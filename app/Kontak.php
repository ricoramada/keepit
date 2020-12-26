<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kontak extends Model
{
    public $timestamps = false;
    
    protected $table = 'kontak';
    protected $fillable = [
        'email',
        'phone',
        'level',
        'username',
        'password'
    ];

}
