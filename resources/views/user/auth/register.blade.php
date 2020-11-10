@extends('layout.auth.app')

@section('title', '従業員登録')

@section('content')
<main>
<div class="container”>
    <div class="row">
      <div class="mx-auto col-8">
        <h1 class="text-center h1"><a class="text-dark">登録してね！</a></h1>
        <div class="card mt-3 h-100">
          <div class="card-body text-center">
          <h2 class="h2 card-title text-center mt-5 mb-5">ユーザー登録</h2>
            <!-- errorメッセージを表示する組み込みテンプレート・効率化-->
            @include('auth.error_card_list')
            <div class="card-text">
              <form method="POST" action="{{ route('user.register') }}">
                @csrf

                <div class="md-form mb-5 mt-5">
                  <label for="name">ユーザー名</label>
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
                  @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                
                <div class="md-form mb-5 mt-5">
                  <label for="password_confirmation">パスワード(確認)</label>
                  <input class="form-control" type="password" id="password_confirmation" name="password_confirmation" required>
                </div>
                <button class="btn btn-block blue-gradient mt-2 mb-2" type="submit">ユーザー登録</button>
              </form>
              <div class="mt-0 h1">
                <a href="{{ route('user.login') }}" class="card-text">ログインはこちら</a>
              </div>        
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection