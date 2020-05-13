@extends('layout.app')

@section('title', 'shift')

@section('side')
    @parent

@endsection

@section('content')
<div class="mt-1">
                <div style="width: 100%">
                    <a class="btn btn-primary d-inline-block" href="#" role="button" style="width:100px">前月</a>
                    <a class="d-inline-block" style="width:200px">2020年４月の勤務状況</a>
                    <a class="d-inline-block btn btn-primary" href="#" role="button" style="width:100px">次月</a>
                </div>
                <div class="mt-5">
                    <table class="table-bordered text-center mr-auto ml-auto w-50">
                        <thead>
                          <tr>
                            <th scope="col">日付</th>
                            <th scope="col">勤務形態</th>
                            <th scope="col">出勤</th>
                            <th scope="col">退勤</th>
                            <th scope="col">休憩</th>
                            <th scope="col">勤務時間</th>
                            <th scope="col">備考</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>01/03/2020</td>
                          </tr>
                        </tbody>
                      </table>
                </div>
                <div>
                    <a class="d-inline-block btn btn-primary" href="#" role="button" style="width:100px">申請</a>
                </div>
            </div>
@endsection