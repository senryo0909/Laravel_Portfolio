@extends('layout.A_app')
@section('title', '管理者ホーム')
@section('content')
<main>
  <div class="container">
    <div class="row">
      <div class="col-lg-4 mb-5">
        <div class="card">
        <div class="text-center" style="font-size: 100px;"><i class="far fa-calendar-alt"></i></div>
          <div class="card-body text-center">
            <h4 class="card-title">勤怠チェック</h4>
            <p class="card-text">従業員からの申請を処理してください。</p>
            <a href="{{ route('admin.approval.index') }}" class="btn btn-primary">勤怠管理画面へ</a>
          </div>
        </div>
      </div>

      <div class="col-lg-4 mb-5">
        <div class="card">
        <div class="text-center" style="font-size: 100px;"><i class="fa fa-tasks ml-1"></i></div>
          <div class="card-body text-center">
            <h4 class="card-title text-danger">タスクチェック（作成中）</h4>
            <p class="card-text">従業員のタスクに関して、チェックをしアドバイスをしてください</p>
            <a href="#" class="btn btn-primary">タスク管理画面へ</a>
          </div>
        </div>
      </div>

      <div class="col-lg-4 mb-5">
        <div class="card">
        <div class="text-center" style="font-size: 100px;"><i class="fas fa-calculator"></i></div>
          <div class="card-body text-center">
            <h4 class="card-title text-danger">KPIチェック（作成中）</h4>
            <p class="card-text">従業員の立てた目標と進捗を把握しましょう</p>
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
