<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class usermodel extends Model
{
    protected $table = 'user';
    protected $fillable = ['name', 'email','mobile_number','gender','dob','age'];
}
