<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Management extends Model
{
    //ManagementsテーブルはUsersテーブル全体に対して、複数レコードがUsersテーブルの１レコードに全て紐づいている。
    public function user(){
        return $this->belongTo('App\User');
    }
    //Managementsテーブルはshiftsテーブル全体に対して、１レコードが複数のshiftsテーブルを所有している。
    public function shift(){
        return $this->hasMany('App\Shift', 'monthly_id');
    }
}
