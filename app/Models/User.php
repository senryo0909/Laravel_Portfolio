<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Database\Eloquent\SoftDelete;

class User extends Authenticatable
{
    use Notifiable;
    //softdeleteの設定
    // use SoftDelete;
    // protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
     'email', 'name', 'password', 'email_verified_at', 'remember_token', 'updated_at', 'created_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'tel'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    //Usersテーブルはshiftsレコード全体に対して、1レコードにつき複数のレコードと紐づいている。
    public function shift(){
        return $this->hasMany('App\Shift');
    }
    //Usersテーブルは、1レコードにつきmanagementsテーブルの複数のレコードと紐づいている。
    public function management(){
        return $this->hasMany('App\Management');
    }

}
