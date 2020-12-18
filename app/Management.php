<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Management extends Model
{    
    protected $table = 'managements';
    public $timestamps = false;
    //managementsの１レコードに対して、usersの1つのレコードが紐付けられる
    
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    
    //Managementsテーブルはshiftsテーブル全体に対して、１レコードが複数のshiftsテーブルを所有している。
    public function shift(){
        return $this->hasMany('App\Shift', 'monthly_id');
    }
    
    public function approval(){
        return $this->hasOne('App\ShiftsApproval', 'managements_id');
    }
}
