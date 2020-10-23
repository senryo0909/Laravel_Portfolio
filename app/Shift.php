<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Database\Eloquent\SoftDelete;

class Shift extends Model
{
    public $timestamps = false;
    protected $fillable = ['start_time', 'end_time', 'rest_time', 'total', 'comments', 'work_type_id', 'user_id', 'monthly_id', 'date'];
    
    //shiftsレコードは、Usersレコード全体に対して、複数のレコードが１つだけのUsersレコードに紐づいている
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    
    //shiftsレコードは、work_typesレコード全体に対して、複数のレコードが１つだけのwork_typesレコードに紐づいている
    public function work(){
        return $this->belongsTo('App\WorkType', 'work_type_id');
    }
    
    //shiftsレコードは、managementsレコード全体に対して、複数のレコードが１つだけのmanagementsレコードに紐づいている
    public function management(){
        return $this->belongsTo('App\Management', 'monthly_id');
    }
    
    public function get_shift(){
        $user_id = Auth::id();
        $shifts = $this::where('user_id', $user_id)
            ->where('date', 'like', '%' . $this->year . '-' . $this->month . '%')
            ->latest()
            ->get();
         return $shifts;
    }
}