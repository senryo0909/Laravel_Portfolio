<?php

namespace App\Http\Controllers;
//Shiftモデルクラスを呼び出し
// use App\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller{
    //一覧画面へのアクセスケース
    
    public function index(){
    // $current = date('Y-m');
    // $shifts = new Shift();
    // $date = $shift->whereMonth(date, $current)->get();
        return 1;
    // return view('shift.index')->with('date', $date);
    }
}
