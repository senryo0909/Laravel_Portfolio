<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkType extends Model
{
    //work_typesテーブルは１レコードに対して、複数のshiftsテーブルと紐づいている。
    public $timestamps = false;

    public function shift(){
        return $this->hasMany('App\Shift', 'work_type_id');
    }
}
