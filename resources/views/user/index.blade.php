@extends('layout.U_app')
@section('title', '勤怠入力')
@section('content')
<!-- <div class="mt-1"> -->
    {{-- 過去未来のシフト検索 --}}

    <!-- <div style="width: 100%"> -->
    {{-- date(指定したフォーマット、1970からの時間経過の数字) = 2020-10-01など--}}
    {{-- strtotime(基準の日時文字列2020-10-01など、基準となる日時) --}}
        
    
    <!-- シフト入力項目 -->
<main>
  <div class="text-center">
      <a class="btn btn-primary" href="{{ route('user.shifts.switch', ['dates' => date('Y-m-d', strtotime(date($dateNum).'-1 month'))]) }}">前月</a>
      <span class="h3 align-middle">{!! substr($dates[0], 0, 4) !!}年{!! substr($dates[0], 5, 2) !!}月の勤務状況</span>
      <a class="btn btn-primary" href="{{ route('user.shifts.switch', ['dates' => date('Y-m-d', strtotime(date($dateNum).'+1 month'))]) }}">次月</a>
  </div>
  <div class="mt-5">
        <table class="table-bordered text-center w-100">
            <thead>
              <tr>
                <th class="h2">日付</th>
                <th class="h2">勤務形態</th>
                <th class="h2">出勤</th>
                <th class="h2">退勤</th>
                <th class="h2">休憩</th>
                <th class="h2">勤務時間</th>
                <th class="h2">備考</th>
              </tr>
            </thead>   
        <tbody>
  <!--　年月日表示 -->
      @foreach($dates as $date)
  <!-- 勤怠入力済みの表示のスタート地点 -->
        @if(isset($shifts[$date]))
  <!--　土日は赤字で表示 -->
        @if(substr($shifts[$date]->date, -5, 5) === '(土)' || substr($shifts[$date]->date, -5, 5) === '(日)')
          <tr style="color: red;">
        @else
          <tr>
        @endif
            <td class="h4">{{ $shifts[$date]->date }}</td>
            <td style="height: 10px;">
            <select id="true" name="work_type_id" data-id="{{ $shifts[$date]->id }}" data-date="{{ $shifts[$date]->date }}"style="display: inline-block; width: 100%; height: 100%">
              @if($shifts[$date]->work_type_id === null)
                @for($i = 0; $i < 7; $i++)
                    @if($i === 0)
                      <?php $type = '選択してね'; ?>
                    @elseif($i === 1)
                      <?php $type = '出勤'; ?>
                    @elseif($i === 2)
                      <?php $type = '有給'; ?>
                    @elseif($i === 3)
                      <?php $type = '欠勤'; ?>
                    @elseif($i === 4)
                      <?php $type = '早退'; ?>
                    @elseif($i === 5)
                      <?php $type = '半休'; ?>
                    @elseif($i === 6)
                      <?php $type = '休日'; ?>
                    @endif  
                  <option value="{{ $i }}">{{ $type }}</option>
                  
                @endfor
              
              @elseif($shifts[$date]->work_type_id === 1 || $shifts[$date]->work_type_id === 2 || $shifts[$date]->work_type_id === 3 || $shifts[$date]->work_type_id === 4 || $shifts[$date]->work_type_id === 5 || $shifts[$date]->work_type_id === 6)
                
                @for($i = 1; $i < 7; $i++)
                    @if($i === 1)
                      <?php $type = '出勤'; ?>
                    @elseif($i === 2)
                      <?php $type = '有給'; ?>
                    @elseif($i === 3)
                      <?php $type = '欠勤'; ?>
                    @elseif($i === 4)
                      <?php $type = '早退'; ?>
                    @elseif($i === 5)
                      <?php $type = '半休'; ?>
                    @elseif($i === 6)
                      <?php $type = '休日'; ?>
                    @endif

                    @if($shifts[$date]->work_type_id === $i)
                      <option selected value="{{ $shifts[$date]->work_type_id }}">{{ $type }}</option>
                    @elseif($shifts[$date]->work_type_id !== $i)
                      <option value="{{ $i }}">{{ $type }}</option>
                    @endif

                @endfor
              @endif
              </select>
            </td>  
  
  <td style="height: 10px;">
  <select name="start_time" data-id="{{ $shifts[$date]->id }}" data-date="{{ $shifts[$date]->date }}" style="display: inline-block; width: 100%; height: 100%">
    
    @if($shifts[$date]->start_time === null)
      <option selected value="00:00:00">選択してね</option> 
    @endif
    <!-- 有給・欠勤用の0 -->
    @if($shifts[$date]->start_time === "00:00:00")
      <!-- <option value="{{ substr($shifts[$date]->start_time, 0, 5) }}">0:00</option> -->
      <option value="{{ $shifts[$date]->start_time }}">0:00</option>
    @elseif($shifts[$date]->start_time !== "00:00:00")
      <option value="00:00:00">0:00</option>
    @endif

    @for($i = 8; $i < 10; $i++);
     @if($shifts[$date]->start_time === "0" . $i . ":00:00")
      <option selected value="{{ substr($shifts[$date]->start_time, 0, 5) }}">{{ $i }}:00</option>
     @elseif($shifts[$date]->start_time !== "0" . $i . ":00:00")
      <option value="0{{ $i }}:00:00">{{ $i }}:00</option>
     @endif
  　@endfor
      
    @for($i = 10; $i < 23; $i++);
      @if($shifts[$date]->start_time === $i . ":00:00")
        <option selected value="{{ substr($shifts[$date]->start_time, 0, 5) }}">{{ $i }}:00</option>
      @elseif($shifts[$date]->start_time !==  $i . ":00:00")
        <option value="{{ $i }}:00:00">{{ $i }}:00</option>
      @endif
    @endfor
    
    </select>
  </td>
  
  <td style="height: 10px;">
    <select name="end_time" data-id="{{ $shifts[$date]->id }}" data-date="{{ $shifts[$date]->date }}" style="display: inline-block; width: 100%; height: 100%;">
    @if($shifts[$date]->end_time === null)
      <option selected value="00:00:00">選択してね</option> 
    @endif

    <!-- 有給・欠勤用の0 -->
    @if($shifts[$date]->end_time === "00:00:00")
      <option value="{{ substr($shifts[$date]->end_time, 0, 5) }}">0:00</option>
    @elseif($shifts[$date]->end_time !== "00:00:00")
      <option value="00:00:00">0:00</option>
    @endif

    @for($i = 8; $i < 10; $i++);
      @if($shifts[$date]->end_time === "0" . $i . ":00:00")
        <option selected value="{{ substr($shifts[$date]->end_time, 0, 5) }}">{{ $i }}:00</option>
      @elseif($shifts[$date]->end_time !== "0" . $i . ":00:00")
        <option value="0{{ $i }}:00:00">{{ $i }}:00</option>
      @endif
    @endfor

    @for($i = 10; $i < 23; $i++);
      @if($shifts[$date]->end_time === $i . ":00:00")
        <option selected value="{{ substr($shifts[$date]->end_time, 0, 5) }}">{{ $i }}:00</option>
      @elseif($shifts[$date]->end_time !==  $i . ":00:00")
        <option value="{{ $i }}:00:00">{{ $i }}:00</option>
      @endif
    @endfor
    </select>
  </td>
  
  <td style="height: 10px;">
    <select name="rest_time" data-id="{{ $shifts[$date]->id }}" data-date="{{ $shifts[$date]->date }}" style="display: inline-block; width: 100%; height: 100%;">
    @if($shifts[$date]->rest_time === null)
      <option selected value="00:00:00">選択してね</option> 
    @endif
      @for($i = 0; $i < 3; $i++)
        @if($shifts[$date]->rest_time === "0" . $i . ":00:00")
          <option selected value="{{ substr($shifts[$date]->rest_time, 1, 5) }}">{{ $i }}:00</option>
        @elseif($shifts[$date]->end_time !==  $i . ":00:00")
          <option value="{{ $i }}:00:00">{{ $i }}:00</option>
        @endif
      @endfor
    </select>
  </td>
  
  <td style="height: 10px;">
    <select name="total" data-id="{{ $shifts[$date]->id }}" data-date="{{ $shifts[$date]->date }}" style="display: inline-block; width: 100%; height: 100%;">
    @if($shifts[$date]->total === null)
      <option selected value="00:00:00">選択してね</option> 
    @endif
    
    @if($shifts[$date]->total_time === "00:00:00")
      <option value="{{ substr($shifts[$date]->end_time, 0, 5) }}">0:00</option>
    @elseif($shifts[$date]->total_time !== "00:00:00")
      <option value="00:00:00">0:00</option>
    @endif

    @for($i = 1; $i < 10; $i++);
      @if($shifts[$date]->total === "0" . $i . ":00:00")
        <option selected value="{{ substr($shifts[$date]->total, 0, 5) }}">{{ $i }}:00</option>
      @elseif($shifts[$date]->total !== "0" . $i . ":00:00")
        <option value="0{{ $i }}:00:00">{{ $i }}:00</option>
      @endif
    @endfor

    @for($i = 10; $i < 23; $i++);
      @if($shifts[$date]->total === $i . ":00:00")
        <option selected value="{{ substr($shifts[$date]->total, 0, 5) }}">{{ $i }}:00</option>
      @elseif($shifts[$date]->total !==  $i . ":00:00")
        <option value="{{ $i }}:00:00">{{ $i }}:00</option>
      @endif
    @endfor
    </select>
  </td>

  <td>
    <input type="text" data-id="{{ $shifts[$date]->id }}" data-date="{{ $shifts[$date]->date }}" name="comments" value="{{ $shifts[$date]->comments }}" placeholder="自由記載" style="display: inline-block; width: 100%;">
  </td>
  <input type="hidden" data-id="{{ $shifts[$date]->id }}" data-date="{{ $shifts[$date]->date }}" name="monthly_id" value="{{ $shifts[$date]->monthly_id }}">
  <input type="hidden" data-id="{{ $shifts[$date]->id }}" data-date="{{ $shifts[$date]->date }}" name="user_id" value="{{ $shifts[$date]->user_id }}">
  @if(isset($shifts[$date]->management->approval->status_descriptions_id))
  <input type="hidden" data-id="{{ $shifts[$date]->id }}" data-date="{{ $shifts[$date]->date }}" name="status_descriptions_id" value="{{ $shifts[$date]->management->approval->status_descriptions_id }}">
  @endif
  <input type="hidden" id="first_day" value="{{ $dates[0] }}">
</tr>

  @else

  {{-- 勤怠"未入力"表示のスタート地点 --}}
  {{-- 土日は赤字 --}}
  @if(substr($date, -5, 5) === '(土)' || substr($date, -5, 5) === '(日)')
    <tr style="color: red;">
  @else
    <tr>
  @endif
        <td>{{ $date }}</td>
        <td style="height: 10px">
          <select id="false" name="work_type_id" data-id="" data-date="{{ $date }}" style="display: inline-block; width: 100%; height: 100%;">
                <option value="0">選択してね</option>
                <option value="1">出勤</option>
                <option value="2">有給</option>
                <option value="3">欠勤</option>
                <option value="4">早退</option>
                <option value="5">半休</option>
                <option value="6">休日</option>
          </select> 
        </td>
        <td style="height: 10px;">
            <select name="start_time" data-id="" data-date="{{ $date }}" style="display: inline-block; width: 100%; height: 100%;">
                <option value="00:00:00">選択してね</option>
                <option value="00:00:00">0:00</option>
                <option value="09:00:00">9:00</option>
              @for($i = 10; $i < 23; $i++);
                <option value="{{ $i }}:00:00">{{ $i }}:00</option>
              @endfor
            </select>
        </td>

        <td style="height: 10px;">
            <select name="end_time" data-id="" data-date="{{ $date }}" style="display: inline-block; width: 100%; height: 100%;">
                <option value="00:00:00">選択してね</option>
                <option value="00:00:00">0:00</option>
                <option value="09:00:00">9:00</option>
              @for($i = 10; $i < 23; $i++);
                <option value="{{ $i }}:00:00">{{ $i }}:00</option>
              @endfor
            </select>
        </td>

        <td style="height: 10px;">
          <select name="rest_time" data-id="" data-date="{{ $date }}" style="display: inline-block; width: 100%; height: 100%;">
          <option value="0">選択クゥ〜</option>
            @for($i = 0; $i < 3; $i++)  
                <option value="{{ $i }}:00:00">{{ $i }}:00</option>
            @endfor
          </select>
        </td>

        <td style="height: 10px;">
          <select name="total" data-id="" data-date="{{ $date }}" style="display: inline-block; width: 100%; height: 100%;">
          <option value="00:00:00">選択してね</option>
            @for($i = 0; $i < 16; $i++)  
                <option value="{{ $i }}:00:00">{{ $i }}:00</option>
            @endfor
          </select>
        </td>

        <td style="height: 10px;">
          <input id="err" type="text" name="comments" data-id="" data-date="{{ $date }}" value="" placeholder="自由記載" style="display: inline-block; width: 100%;">
        </td>
        <input type="hidden" data-id="" name="user_id" value="{{ Auth::user()->id }}">
        <input type="hidden" data-id="" name="monthly_id" value="">
        
    </tr>
        @endif
    @endforeach
  </tbody>
</table>
    <!-- </div> -->
    <div class="text-center">
    <button type="submit" class="btn btn-primary mt-5" style="width: 100px" id="submit">申請</button>
    </div>
<!-- </div> -->
</main>
@endsection


