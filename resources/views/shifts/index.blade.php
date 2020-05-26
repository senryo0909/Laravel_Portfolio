@extends('layout.app')

@section('title', 'shift')

<!-- @section('layout.side')
@endsection -->

@section('content')
<div class="mt-1">
                <div style="width: 100%">
                    <a class="btn btn-primary d-inline-block" href="#" role="button" style="width:100px">前月</a>
                    <a class="d-inline-block" style="width:200px">2020年４月の勤務状況</a>
                    <a class="d-inline-block btn btn-primary" href="#" role="button" style="width:100px">次月</a>
                </div>
                <div class="mt-5">
                    <table class="table-bordered text-center mr-auto ml-auto w-100">
                        <thead>
                          <tr>
                            <th scope="col">日付</th>
                            <th scope="col">勤務形態</th>
                            <th scope="col">出勤</th>
                            <th scope="col">退勤</th>
                            <th scope="col">休憩</th>
                            <th scope="col">勤務時間</th>
                            <th scope="col" class="w-50">備考</th>
                          </tr>
                        </thead>
                        <tbody>
                        {{-- shiftsテーブル作成後に移行させたい処理をコメントで表示 --}}
                        {{-- @forelse($shifts as $shift) --}}

                          {{-- <tr>
                            <td><input type="text" id="type" name="type" maxlength="2" value="{{ $shift->date}}"></td>
                            <td><input type="text" id="start" name="start" maxlength="5" value="{{ $shift->start_time }}"></td>
                            <td><input type="text" id="end" name="end" maxlength="5" value="{{ $shift->end_time }}"></td>
                            <td><input type="text" id="rest" name="rest" maxlength="5" value="{{ $shift->rest_time }}"></td>
                            <td><input type="text" id="total" name="total" maxlength="5" value="{{ $shift->total }}"></td>
                            <td><input type="text" id="comment" name="comment" maxlength="5" value="{{ $shift->comment }}"></td> --}}
                          <tr>
                            <td>01/03/2020</td>
                            <td><input type="text" id="type" name="type" maxlength="2" value="" placeholder="出勤/欠勤/有給/半休/早退"></td>
                            <td><input type="text" id="start" name="start" maxlength="5" value="" placeholder="09:00"></td>
                            <td><input type="text" id="end" name="end" maxlength="5" value="" placeholder="18:00"></td>
                            <td><input type="text" id="rest" name="rest" maxlength="5" value="" placeholder="01:00"></td>
                            <td><input type="text" id="total" name="total" maxlength="5" value="" placeholder="08:00"></td>
                            <td><input type="text" id="comment" name="comment" maxlength="5" value="" placeholder="自由記載"></td>
                          </tr>
                        </tbody>
                      </table>
                </div>
                <div>
                <button type="submit" class="btn btn-primary mt-5" style="width: 100px" id="submit">申請</button>
                </div>
            </div>
@endsection
@section('js')
$(function(){
            $('#submit').on('click',function(){
              
                var type = $("#type").val();
                var start = $("#start").val();
                var end = $("#end").val();
                var rest = $("#rest").val();
                var total = $("#total").val();
            
                (type == '')?alert("勤務形態が未入力です"):true;
                (start == '')?alert("勤務開始時刻が未入力です"):true;
                (end == '')?alert("退勤時刻が未入力です"):true;
                (rest == '')?alert("休憩時間が未入力です"):true;
                (type.length != 2)?alert("漢字２文字で記入"):true;
                (start.match(/^\d{1,2}\:\d{2}$/))?true:alert('勤務時間は時刻形式で記入');
                (end.match(/^\d{1,2}\:\d{2}$/))?true:alert('退勤時間は時刻形式で記入');
                (rest.match(/^\d{1,2}\:\d{2}$/))?true:alert('休憩時間は時刻形式で記入');
            });
            
            });
@endsection