<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class address extends Model
{
    protected $table = 'address';
    protected $fillable = ['address', 'city','state','pincode','user_id'];
}
