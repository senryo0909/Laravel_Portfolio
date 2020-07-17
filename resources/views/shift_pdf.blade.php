<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>PDF</title>
<style>
/* @import url('https://fonts.googleapis.com/css2?family=Ma+Shan+Zheng&display=swap'); */
@font-face{
    font-family: ipag;
    /* font-family: MPLUS1p; */
    font-style: normal;
    font-weight: normal;
    src:url('{{ storage_path('ipag.ttf') }}');
    /* src:url('{{ storage_path('fonts/MPLUS1p-Regular.ttf') }}'); */
}
@font-face{
    font-family: ipag;
    /* font-family: MPLUS1p; */
    font-style: bold;
    font-weight: bold;
    src:url('{{ storage_path('ipag.ttf') }}');
    /* src:url('{{ storage_path('fonts/MPLUS1p-Bold.ttf') }}'); */
}
body {
font-family: ipag;
/* font-family: MPLUS1p; */
/* font-family: 'M PLUS 1p', sans-serif; */
/* font-family: 'Ma Shan Zheng', cursive; */
font-size: 14px;
}
table{
    text-align: center;
}
</style>
</head>
<body>

<div>
   <pre>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$year}}</pre>
   <table>
   <tr>
    <th>氏名:</th>
    <td style="margin-left: 10px;">{{ $user }}</td>
   </tr>
   <tr>
    <th>従業員ID:</th>
    <td>{{ $user_id }}</td>
   </tr>
   </table>
</div>

<div>
    <p>&nbsp;時間集計</p>
    <table border="0.5px">
    <tr>
        <th>&nbsp;&nbsp; 総勤務時間（時）</th>
        <td>&nbsp;&nbsp;{{ $totalTimes }}&nbsp;</td>
        <th>&nbsp;&nbsp; 総休憩時間（時）</th>
        <td>&nbsp;&nbsp;{{ $totalRest }}&nbsp;</td>
    </tr>
    </table>
</div>

<div>
    <p>&nbsp;日数集計</p>
    <table border="0.5px">
    <tr>
        <th>&nbsp;出勤日数&nbsp;&nbsp;</th>
        <td>&nbsp;&nbsp;{{ $all['type'][0]['work'] }}&nbsp;&nbsp;</td>
        <th>&nbsp;&nbsp;有給日数&nbsp;&nbsp;</th>
        <td>&nbsp;&nbsp;{{ $all['type'][0]['off'] }}&nbsp;&nbsp;</td>
    </tr>
    <tr>
        <th>&nbsp;&nbsp;欠勤日数&nbsp;&nbsp;</th>
        <td>&nbsp;&nbsp;{{ $all['type'][0]['sick'] }}&nbsp;&nbsp;</td>
        <th>&nbsp;&nbsp;早退日数&nbsp;&nbsp;</th>
        <td>&nbsp;&nbsp;{{ $all['type'][0]['early'] }}&nbsp;&nbsp;</td>
    </tr>
    <tr>
        <th>&nbsp;&nbsp;半休日数&nbsp;&nbsp;</th>
        <td>&nbsp;&nbsp;{{ $all['type'][0]['half'] }}&nbsp;</td>
        <th>&nbsp;&nbsp;休日日数&nbsp;&nbsp;</th>
        <td>&nbsp;&nbsp;{{ $all['type'][0]['weekend'] }}&nbsp;</td>
    </tr>
    </table>
</div>

<div>
    <p>シフト詳細</p>
</div>

   <div class="mt-5 text-center">
        <table border="1px" class="table-bordered text-center mr-auto ml-auto w-100">
            <thead>
              <tr>
                <th scope="col" style="width: 30px">日付</th>
                <th scope="col">勤務形態</th>
                <th scope="col">出勤</th>
                <th scope="col">退勤</th>
                <th scope="col">休憩</th>
                <th scope="col">勤務時間</th>
                <th scope="col" style="width: 100px">備考</th>
              </tr>
            </thead>   
            <tbody>
            @foreach($shifts as $shift)
            <tr>
                <td>&nbsp;{{ $shift->date }}&nbsp;</td>
                <td>&nbsp;
                    @if($shift->work_type_id === 1)
                    出勤
                    @elseif($shift->work_type_id === 2)
                    有給
                    @elseif($shift->work_type_id === 3)
                    欠勤
                    @elseif($shift->work_type_id === 4)
                    早退
                    @elseif($shift->work_type_id === 5)
                    半休
                    @elseif($shift->work_type_id === 6)
                    休日
                    @endif
                    &nbsp;
                </td>
                <td>&nbsp;{{ $shift->start_time }}&nbsp;</td>
                <td>&nbsp;{{ $shift->end_time }}&nbsp;</td>
                <td>&nbsp;{{ $shift->rest_time }}&nbsp;</td>
                <td>&nbsp;{{ $shift->total }}&nbsp;</td>
                <td>&nbsp;{{ $shift->comments }}&nbsp;</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>