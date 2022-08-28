@extends('layout.auth.app')

@section('title', '管理者登録')

@section('content')
<main>
  <div class="container">
    <div class="row">
      <div class="mx-auto col-12">
        <h1 class="text-center h1"><a class="text-dark" href="/">登録してね！</a></h1>
        <div class="card mt-3 h-100">
          <div class="card-body text-center">
            <h2 class="h2 card-title text-center mt-5 mb-5">管理者登録</h2>
            @include('auth.error_card_list')
            <div class="card-text">
              <form method="POST" action="{{ route('admin.register') }}">
                @csrf
                <div class="md-form mb-5 mt-5">
                  <label for="name">管理者名</label>
                  <input class="form-control" type="text" id="name" name="name" required value="{{ old('name') }}">
                  <small>英数字3〜16文字(登録後の変更はできません)</small>
                </div>
                <div class="md-form mb-5 mt-5">
                  <label for="email">メールアドレス</label>
                  <input class="form-control" type="text" id="email" name="email" required value="{{ old('email') }}" >
                </div>
                <div class="md-form mb-5 mt-5">
                  <label for="password">パスワード</label>
                  <input class="form-control" type="password" id="password" name="password" required>
                </div>
                <div class="md-form mb-5 mt-5">
                  <label for="password_confirmation">パスワード(確認)</label>
                  <input class="form-control" type="password" id="password_confirmation" name="password_confirmation" required>
                </div>
                <button class="btn btn-block blue-gradient mt-2 mb-2" type="submit">管理者登録</button>
              </form>

              <div class="mt-0 h1">
                <a href="{{ route('admin.login') }}" class="card-text">ログインはこちら</a>
              </div>
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection


