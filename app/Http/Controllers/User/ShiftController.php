<?php
namespace App\Http\Controllers\User;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Http\Requests\StoreShiftPost;

use App\Shift;
use App\Models\User;
use App\Management;
use App\ShiftsApproval;

use App\Http\Controllers\Controller;

class ShiftController extends Controller
{

     public $year = '';
     public $month = '';
     public $day = '';
     public $dates = array();
     public $ld = '';
     public $w = '';
     public $weeks = [
        '(日)', 
        '(月)', 
        '(火)', 
        '(水)', 
        '(木)',
        '(金)', 
        '(土)',
      ];

     //「2020-〇〇-〇〇-〇曜」形式で全日程を取得するメソッド
     //引数が無い場合は呼び出した日の西暦年月日曜日を返り値としてreturn
    private function CurrentDate($date = null)
    {
        //2020-07-05の場合
        if (!$date) {
            $date = date('Y-m-d-w');
        }
      
        //該当月の最終日を$ldに取得、ldには30or31日が入る
         $this->ld = date('d', strtotime('last day of' . $date));
        //（例）2020-10-20を$year = 2020, $month = 10, day = 20にそれぞれ分けて代入
        list($this->year, $this->month, $this->day) = explode("-", $date);
        //日は１から30もしくは31日あり、$this->ldとすることで、一日ずつ$iで取得可能。
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

    //route(/shift)一覧画面の表示
    public function index()
    {
        //CurrentData()で取得した日付に一致するテーブルの全データをget_shift()関数で取得
        $dates = Self::CurrentDate();

        $shifts = new Shift;
        $shifts = $shifts->get_shift();
        //モデルオブジェクトのキー値を値の日付にすることで、取得しやすいように加工
        $shifts = $shifts->keyBy('date');
        $dateNum = str_replace('-', '', $dates[0]);
        $dateNum = substr($dateNum, 0, 8);

        // return view('shifts.index', 
        // ['dates' => $dates,
        //  'shifts' => $shifts,
        //  'dateNum' => $dateNum
        // ]);

        // compact関数は、引数指定された文字列をキーに => 変数 変換してくれる。
        return view('user.index', compact('dates', 'shifts', 'dateNum'));

    }

    //過去・未来のシフト表示リクエスト
    public function switch($date)
    {
        (string) $date = $date . '-' . date('w', strtotime(str_replace('-', '', $date)));
        $dates = Self::CurrentDate($date);
        
        $shifts = new Shift;
        $shifts = $shifts->get_shift();
        $shifts = $shifts->keyBy('date');
        $dateNum = str_replace('-', '', $dates[0]);
        $dateNum = substr($dateNum, 0, 8);
      
        return view('user.index', compact('dates', 'shifts', 'dateNum'));
    }

    public function store_ajax(StoreShiftPost $request)
    {
      
        //配列でリクエストを取得
        $input = array();
        $input = $request->except('_token');
        // $validate_rule = Validator::make($input, [
        //     'comments' => 'nullable|max:20',
        // ]);
        //すでに登録済みのシフト情報の更新処理
        if ($input["id"]) {
            $shifts = Shift::find($input["id"]);     
            $shifts->user_id = $input["user_id"];
            if ($input["column"] === "work_type_id") {
                $shifts->work_type_id = $input["values"];
            } elseif ($input["column"] === "start_time") {
                $shifts->start_time = $input["values"];
            } elseif ($input["column"] === "end_time") {
                $shifts->end_time = $input["values"];
            } elseif ($input["column"] === "rest_time") {
                $shifts->rest_time = $input["values"];
            } elseif ($input["column"] === "total") {
                $shifts->total = $input["values"];
            } elseif ($input["column"] === "comments") {
                $shifts->comments = $input["values"];
            }
        //新規登録の処理
        } elseif (!$input["id"]) {

            $shifts = new Shift;
            $shifts->date = $input["date"];
            $shifts->user_id = $input["user_id"];

            if ($input["column"] === "work_type_id") {
                $shifts->work_type_id = $input["values"];
            } elseif ($input["column"] === "start_time") {
                $shifts->start_time = $input["values"];
            } elseif ($input["column"] === "end_time") {
                $shifts->end_time = $input["values"];
            } elseif ($input["column"] === "rest_time") {
                $shifts->rest_time = $input["values"];
            } elseif ($input["column"] === "total") {
                $shifts->total = $input["values"];
            } elseif ($input["column"] === "comments") {
                $shifts->comments = $input["values"];
            }
        }
        
        $shifts->save(); 
        //もし有給の申請であれば
        if ($input["column"] === "work_type_id") {
            // 初期データ
            $data = [
                'start_time' => '09:00:00',
                'end_time' => '18:00:00',
                'rest_time' => '01:00:00',
                'total' => '08:00:00',
            ];

            switch($input["values"])
            {  
                case 1:
                    $this->begin();
                    try {
                        $shifts->fill($data);
                        $shifts->save();
                        $this->commit();
                    } catch (\Exception $e) {
                        $this->rollback();
                    }
                    break;
                case 2:
                case 3:
                case 6:
                    $this->begin();
                    try {
                        $data['start_time'] = '00:00:00';
                        $data['end_time'] = '00:00:00';
                        $data['rest_time'] = '00:00:00';
                        $data['total'] = '00:00:00';
                        $shifts->fill($data);
                        $shifts->save();
                        $this->commit();
                    } catch (\Exception $e) {
                        $this->rollback();
                    }
                    break;
                case 4:
                case 5:
                    $this->begin();
                    try {
                        $data['end_time'] = '14:00:00';
                        $data['rest_time'] = '00:00:00';
                        $data['total'] = '05:00:00';
                        $shifts->fill($data);
                        $shifts->save();
                        $this->commit();
                    } catch (\Exception $e) {
                        $this->rollback();
                    }
                    break;
            }
        }
        return $shifts->id;
    }

    public function store_monthly(Request $request)
    {
        //申請ボタンからシフトの申請月としてdateをリクエストで受け取る。
        $input = array();
        $input = $request->except('_token');
        $input = substr($input["date"], 0, 7);
        //ログインしているユーザーIDを取得
        $user_id = Auth::id();

        //①初めてmanagementに登録してshiftsテーブルにmonhtly_idを付与するパターン
        //->managementsテーブルに新規テーブルを作成してカラムを埋める。
        //->shiftsテーブルの該当する年月にmonthly_idを付与する
        //->shifts_approvalsテーブルにmanagements_idとstatus_descriptionを付与する（申請中ステータス）

        //②既にmanagementに登録しているパターン
        //①で既に何らかのstatus_descriptionは付与されているので、その値を”申請中”に変える
        
        //②のパターン。
        $check = '';
        $check = Management::where('user_id', $user_id)->where('year_month', 'like', "%$input%")->first();
        //既にmanagementテーブルに登録あるシフトの変更申請の場合
        if ( isset($check) ) {
            //トランザクション開始
            $this->begin();
            try {
                //該当するレコードをシフト申請チェックのテーブル（ShiftsApproval)から申請した年月のIDをベースに取得
                $shifts_approvals = ShiftsApproval::where('management_id', $check->id);
                //ShiftsApprovalの該当レコードの承認状況を変更
                $shifts_approvals->status_descriptions_id = 1;
                $shifts_approvals->save();
                $this->commit();
            } catch (\Exception $e) {
                $this->rollback(); 
            }
        } else {
            //①初めてのシフト申請のパターン
            $this->begin();
            try {
                //Managementテーブルに新たなレコードを「ユーザーID」、「年月」をベースに反映
                $management = new Management();
                $management->user_id = $user_id;
                $management->year_month = $input;
                $management->save();
                //ShiftsApprovalテーブルに新たなレコードをManagementテーブルの主キーを外部キーとして反映
                $shifts_approvals = new ShiftsApproval();
                $shifts_approvals->managements_id = $management->id;
                //申請中に反映
                $shifts_approvals->status_descriptions_id = 1;
                $shifts_approvals->save();
                //shiftsテーブルの該当月の全日程にmanagementのIDを付与。
                $shifts = Shift::where('user_id', $user_id)->where('date', 'like', "%$input%")->get();
                foreach ($shifts as $shift) {
                    $shift->monthly_id = $management->id;
                    $shift->save();
                }
                $this->commit();
            } catch (\Exception $e) {
                $this->rollback();
            }
        }
    }    
}

