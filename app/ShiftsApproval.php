<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class ShiftsApproval extends Model
{
    protected $fillable = ['managements_id', 'status_descriptions_id'];
    
    //shifts_approvalsテーブルの1レコードがmanagementsテーブルの1つだけを持っている。（複数はない）
    public function management(){
        return $this->belongsTo('App\Management', 'managements_id');
    }

    public function status(){
        return $this->belongTo('App\StatusDescription');
    }


}
