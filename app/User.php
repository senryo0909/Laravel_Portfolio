<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
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
    //Usersテーブルはmanagementsレコード全体に対して、1レコードにつき複数のレコードと紐づいている。
    public function management(){
        return $this->hasMany('App\Management');
    }

}
