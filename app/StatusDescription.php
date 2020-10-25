<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusDescription extends Model
{
    public function shifts_approval(){
        return $this->hasMany('App\ShiftsApproval');
    }
}
