@extends('layout.A_app')
@section('title', '勤怠詳細')
@section('content')
<main>
<div class="mt-1">
    <h1 class="text-center">{{ $user_name }}さんの{{ $year_month }}月の申請内容</h1>
  
    <div class="mt-5">
        <table class="table-bordered text-center mr-auto ml-auto w-100">
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
                <td>{{ $shift->date }}</td>
                <td>
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
                </td>
                <td style="height: 10px;">{{ $shift->start_time }}</td>
                <td style="height: 10px;">{{ $shift->end_time }}</td>
                <td style="height: 10px;">{{ $shift->rest_time }}</td>
                <td style="height: 10px;">{{ $shift->total }}</td>
                <td style="height: 10px;">{{ $shift->comments }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
</main>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script> -->
<script src="{{ asset('/js/approve.js') }}"></script>