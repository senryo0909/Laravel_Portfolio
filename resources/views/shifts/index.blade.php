@extends('layout.app')

@section('title', 'shift')

 @section('layout.side')
@endsection 

@section('content')
<div class="mt-1">
    <div style="width: 100%">
        <a class="btn btn-primary text-light d-inline-block" href="{{ route('user.shifts.switch', ['dates' => date('Y-m-d', strtotime(date($dateNum).'-1 month')) ]) }}" role="button" style="width:100px">前月</a>
        <a class="d-inline-block" style="font-size: 2rem; width: 250px;">{!! substr($dates[0], 0, 4) !!}年{!! substr($dates[0], 5, 2) !!}月の勤務状況</a>
        <a class="d-inline-block text-light btn btn-primary" href="{{ route('user.shifts.switch', ['dates' => date('Y-m-d', strtotime(date($dateNum).'+1 month')) ]) }}" role="button" style="width:100px">次月</a>
    </div>
  
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

              {{-- 勤怠入力あり--}}

      @foreach($dates as $date)
        @if(isset($shifts[$date]))
        <!-- 土日は赤字-->
        @if(substr($shifts[$date]->date, -5, 5) === '(土)' || substr($shifts[$date]->date, -5, 5) === '(日)')
          <tr style="color: red;">
        @else
          <tr>
        @endif
  <td>{{ $shifts[$date]->date }}</td>
    <td style="height: 10px;">
    <select id="1" name="work_type_id" data-id="{{ $shifts[$date]->id }}" data-date="{{ $shifts[$date]->date }}" style="display: inline-block; width: 100%; height: 100%">
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

    <!-- @if($shifts[$date]->start_time === "09:00:00")
      <option value="{{ substr($shifts[$date]->start_time, 0, 5) }}">9:00</option>
    @elseif($shifts[$date]->start_time !== "09:00:00")
      <option value="09:00:00">9:00</option>
    @endif -->
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
    <!-- @for($i = 0; $i < 16; $i++)
        @if($shifts[$date]->total === 0 . $i . ':00:00')
          <option selected value="{{ substr($shifts[$date]->total, 1, 5) }}">{{ $i }}:00</option>
        @elseif($shifts[$date]->total !== 0 .$i . ":00:00")
          <option value="{{ $i }}:00:00">{{ $i }}:00</option>
        @endif
    @endfor -->
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

  <td><input type="text" data-id="{{ $shifts[$date]->id }}" data-date="{{ $shifts[$date]->date }}" name="comments" maxlength="5" value="{{ $shifts[$date]->comments }}" placeholder="自由記載" style="display: inline-block; width: 100%;"></td>
  <input type="hidden" data-id="{{ $shifts[$date]->id }}" data-date="{{ $shifts[$date]->date }}" name="monthly_id" value="{{ $shifts[$date]->monthly_id }}">
  <input type="hidden" data-id="{{ $shifts[$date]->id }}" data-date="{{ $shifts[$date]->date }}" name="user_id" value="{{ $shifts[$date]->user_id }}">
  @if(isset($shifts[$date]->management->approval->status_descriptions_id))
  <input type="hidden" data-id="{{ $shifts[$date]->id }}" data-date="{{ $shifts[$date]->date }}" name="status_descriptions_id" value="{{ $shifts[$date]->management->approval->status_descriptions_id }}">
  @endif
  <input type="hidden" id="first_day" value="{{ $dates[0] }}">
</tr>

    @else

  <!-- 勤怠入力なし -->
  <!-- 土日は赤字 -->
  @if(substr($date, -5, 5) === '(土)' || substr($date, -5, 5) === '(日)')
    <tr style="color: red;">
  @else
    <tr>
  @endif
        <td>{{ $date }}</td>
        <td style="height: 10px">
          <select name="work_type_id" data-id="" data-date="{{ $date }}" style="display: inline-block; width: 100%; height: 100%;">
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
          <input type="text" name="comments" data-id="" data-date="{{ $date }}" maxlength="5" value="" placeholder="自由記載" style="display: inline-block; width: 100%;">
        </td>
        <input type="hidden" data-id="" name="user_id" value="{{ Auth::user()->id }}">
        <input type="hidden" data-id="" name="monthly_id" value="">
        
    </tr>
        @endif
    @endforeach
  </tbody>
</table>
    </div>
    <div>
     
    <button disabled type="submit" class="btn btn-primary mt-5" style="width: 100px" id="submit">申請</button>
    </div>
</div>
@endsection


