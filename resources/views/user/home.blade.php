@extends('layout.U_app')
@section('title', '従業員ホーム')
@section('content')
<main>
  <div class="container">
    <div class="row">
      <div class="col-lg-4 mb-5">
        <div class="card">
        <div class="text-center" style="font-size: 100px;"><i class="far fa-calendar-alt"></i></div>
          <div class="card-body text-center">
            <h4 class="card-title">勤怠管理</h4>
            <p class="card-text">管理者への勤怠報告業をお願いします。</p>
            <a href="{{ route('user.shifts.index') }}" class="btn btn-primary">勤怠管理画面へ</a>
          </div>
        </div>
      </div>

      <div class="col-lg-4 mb-5">
        <div class="card">
        <div class="text-center" style="font-size: 100px;"><i class="fa fa-tasks ml-1"></i></div>
          <div class="card-body text-center">
            <h4 class="card-title text-danger">タスク管理（作成中）</h4>
            <p class="card-text">ご自身の日々のタスクを管理してください</p>
            <a href="#" class="btn btn-primary">タスク管理画面へ</a>
          </div>
        </div>
      </div>

      <div class="col-lg-4 mb-5">
        <div class="card">
        <div class="text-center" style="font-size: 100px;"><i class="fas fa-calculator"></i></div>
          <div class="card-body text-center">
            <h4 class="card-title text-danger">KPI管理（作成中）</h4>
            <p class="card-text">ここには営業のKPIと目標数字の進捗管理管理を予定中</p>
            <a href="#" class="btn btn-primary">KPI管理画面へ</a>
          </div>
        </div>
      </div>

      <div class="col-lg-4 mb-5">
        <div class="card">
        <div class="text-center" style="font-size: 100px;"><i class="far fa-folder-open"></i></div>
          <div class="card-body text-center">
            <h4 class="card-title text-danger">ドキュメント管理（作成中）</h4>
            <p class="card-text">全ての共有ドキュメントをここで管理できます。</p>
            <a href="#" class="btn btn-primary">ドキュメント管理画面へ</a>
          </div>
        </div>
      </div>

      <div class="col-lg-4 mb-5">
        <div class="card">
        <div class="text-center text-center" style="font-size: 100px;"><i class="fas fa-gavel"></i></div>
         <div class="card-body text-center">
            <h4 class="card-title text-danger">会議室予約管理（作成中）</h4>
            <p class="card-text">会議に伴う部屋の予約はこちらからお願いします。</p>
            <a href="#" class="btn btn-primary">会議室管理画面へ</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection