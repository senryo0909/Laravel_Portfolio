<?php
//adminユーザーの承認関連に関するcontroller

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\ApprovalRequest;

use App\Shift;
use App\Models\User;
use App\Management;
use App\ShiftsApproval;
use App\StatusDescription;

class ApprovalController extends Controller
{
     public $year = '';
     public $month = '';
     public $day = '';
     public $dates = array();
     public $ld = '';

     //2020-〇〇-〇〇形式で全日程を取得するメソッド
     //引数が無い場合はその日の年月日を指定
     /*** 
      * 2020-〇〇-〇〇-〇〇曜日形式で全日程を取得するメソッド
      * 引数が無い場合はその日の年月日(曜日）を指定
      *
      * @param int $date 日付
      * @return int $this->date
      * @author taku
      * @version 1.1
     */
    private function CurrentDate($date = null)
    {
        if(!$date){
            $date = date('Y-m-d-w');
        }
        //該当月の最終日を$ldに取得
        $this->ld = date('d', strtotime('last day of' . $date));
        list($this->year, $this->month, $this->day) = explode("-", $date);
        
        for($i = 1; $i <= $this->ld; $i++){
            $this->dates[] = 
            $this->year . 
            '-' . 
            $this->month . 
            '-' . 
            str_pad($i, 2, "0", STR_PAD_LEFT) . 
            $this->weeks[
                date('w', strtotime($this->year . $this->month . str_pad($i, 2, "0", STR_PAD_LEFT)))
            ]; 

        }
        return $this->dates;
            
    }
    //承認を待っている
    public function index()
    {
        // \DB::enableQueryLog();
        // リレーション宣言（DB負荷軽減）で、user_idに紐づくuserの名前と、approval_idの数字に対応した日本語で書かれたステータスを加えたmanagementテーブルを作成
        $managements = Management::with(['user','approval'])->get();
        

        // dd(\DB::getQueryLog());
        $lists = array();
        
        //managementsテーブルに紐づくリレーション先の情報を配列に保存
        //viewで表示する内容は、[申請元user名],[申請シフト年月],[申請状況]
        foreach($managements as $management)
        {
            $lists[] = [
                'name' => $management->user->name, 
                'approval' => $management->approval->status_descriptions_id,
                'year' => $management->year_month,
                'id' => $management->id
            ];
        }
        //コレクションメソッドで承認状況を表す数字1−３をもつstatus_descriptions_idをキー値として配列をまとめ、toArrayで配列に戻す。
        $lists = collect($lists)->groupBy('approval')->toArray();

        
        return view('admin.approval', compact('lists'));
       
    }
    public function show($id, $user, $year)
    {
        $shifts = Shift::where('monthly_id', $id)->get();
        $user_name = $user;
        $year_month = $year;
        
        return view('admin.show', compact('shifts', 'user_name', 'year_month'));
    }

    public function store(ApprovalRequest $request)
    {     
        $input = array();
        $input = $request->except('_token');
        $approval = ShiftsApproval::where('managements_id', $input['managements_id'])->first();
        
        $this->begin();
        try{
            $approval->status_descriptions_id = $input["status_descriptions_id"];
            $approval->save();
            $this->commit();
        }catch(\Exception $e){
            $this->rollback();
        }
        return response()->json(["data" => "申請完了"]);
    }
    
}
