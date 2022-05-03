<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'target_amount',
        'deadline',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $guarded = array('id');

  //  public static $rules = array(
  //      'name'=>'required',
  //      'email'=>'email | required|unique:users',
  //      'password'=>'required | alpha-num | confirmed | min:4'
//);

  //  public static $messages = array(
  //      'name.required' => '名前は必ず入力してください',
  //      'email.email' => 'メールアドレスを入力してください',
  //      'email.required' => 'メールアドレスは必ず入力してください',
  //      'email.unique:users' => 'そのメールアドレスは既に登録されています',
  //      'password.required' => 'パスワードは必ず入力してください',
 //       'password.alpha-num' => ' パスワードはアルファベットか数字でご登録ください',
  //      'password.confirm' => 'パスワードが一致していません',
  //      'password.min:4'=>'パスワードは4文字以上でご登録ください'
  //  );
}
