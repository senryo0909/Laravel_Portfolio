<?php

namespace App\Http\Controllers\Admin;
use App\Shift;
use App\Models\User;
use PDF;

use App\Http\Controllers\Controller;

class PDFController extends Controller
{
    public $totalTimes = '';
    public $nums = array();
    public $totalRest = '';
    public $all = array();

  
  


    //$all['total'][0] = 08:00:00, $all['total'][1] = 08:00:00・・・
    private function Plus(Array $times)
    {
        $nums = array();
        $hours = 0;
        $minutes = 0;
        $total = 0;
        
            
        //$time[0] = 08:00:00, $time[1] = 05:00:00
        for($i = 0; $i < count($times); $i++){
            //$time[$i = 0] = 08:00:00
            //exlode(":", $time[$i = 0]) = $num[0] = 08 * 60(時間を分に直す), $num[1] = 00.
            //$hours = $hours('') + 08, $hours('8') + 05・・・
            
            $nums[] = explode(":", $times[$i]);
            $hours =+ $hours + ($nums[$i][0] * 60);
            $minutes =+ $minutes + ($nums[$i][1] * 60);
            
        }
        $total = ($hours + $minutes) / 60;
        return $total;
            
  
    }
    
    public function index($id, $user, $year)
    {
        //年月 = $year
        //氏名 = $user
        //従業員コード = $all['user_id]
        //総勤務時間 = $totalTimes
        //総休憩時間 = $all['rest'][]
        //総勤務日数 = $all['type']['work']
        //総有給日数 = $all['type']['off']
        //総欠勤日数 = $all['type']['sick']
        //総早退日数 = $all['type']['early']
        //総半休日数 = $all['type']['half']
        //シフト詳細 = $shiftsをviewでforeachを回す。

        $shifts = Shift::where('monthly_id', $id)->get();
        $work = 0;
        $off = 0;
        $sick = 0;
        $early = 0;
        $half = 0;
        $weekend = 0;
        // $all = array();

        foreach($shifts as $shift){
            $all['total'][] = $shift->total;
            $all['rest'][] = $shift->rest_time;
            
        switch($shift->work_type_id){
            //出勤 = work_type_id = 1
            case 1:
                $work++;
                break;
            case 2:
                $off++;
                break;
            case 3:
                $sick++;
                break;
            case 4:
                $early++;
                break;
            case 5:
                $half++;
                break;
            case 6:
                $weekend++;
                break;
        }
            $user_id = $shift->user_id;
        }
        $all['type'] = array([
            'work' => $work,
            'off' => $off,
            'sick' => $sick,
            'early' => $early,
            'half' => $half,
            'weekend' => $weekend
        ]);
        
        
        //総勤務時間
        $totalTimes = Self::Plus($all['total']);
        $totalRest = Self::Plus($all['rest']);

       
    	// $pdf = PDF::loadview('admin.pdf', compact('shifts', all['type'], $user, $year, $user_id, $totalTimes, $totalRest));
        $pdf = PDF::loadView('admin.shift_pdf', compact('shifts', 'totalTimes', 'totalRest', 'all', 'user_id', 'year', 'user'));
     
        // return $pdf->stream('admin.shift_pdf.pdf');
        return $pdf->stream('admin.shift_pdf');
    }
}
