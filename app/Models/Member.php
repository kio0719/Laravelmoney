<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $guarded = array('id');

    public static $rules = array(
            'name'=>'required',
            'mail'=>'email',
            'password'=>'alpha-num | confirmed'
    );
}
