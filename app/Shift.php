<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $fillable = ['start_time', 'end_time', 'totall', 'comments', 'work_type'];
    
    //shiftsレコードは、Usersレコード全体に対して、複数のレコードが１つだけのUsersレコードに紐づいている
    public function user(){
        return $this->belongTo('App\User');
    }
    //shiftsレコードは、work_typesレコード全体に対して、複数のレコードが１つだけのwork_typesレコードに紐づいている
    public function work_type(){
        return $this->belongTo('App\WorkType');
    }
    //shiftsレコードは、managementsレコード全体に対して、複数のレコードが１つだけのmanagementsレコードに紐づいている
    public function management(){
        return $this->belongTo('App\Management', 'monthly_id');
    }

}
