@extends('layout.auth.app')

@section('title', '従業員ログイン')

@section('content')
<main>
  <div class="container">
    <div class="row">
      <div class="mx-auto col-8">
        <h1 class="text-center h1"><a class="text-dark">ユーザーログイン</a></h1>
        <div class="card mt-3 h-100">
          <div class="card-body text-center">
            <h2 class="h2 card-title text-center mt-5 mb-5">ログイン</h2>
            @include('auth.error_card_list')          
            <div class="card-text">
              <form method="POST" action="{{ route('user.login') }}">
                @csrf

                <div class="md-form mb-5 mt-5">
                  <label for="email">メールアドレス</label>
                  <input class="form-control" type="text" id="email" name="email" required value="abc123@gmail.com"{{ old('email') }}">
                </div>

                <div class="md-form mb-5 mt-5">
                  <label for="password">パスワード</label>
                  <input class="form-control" type="password" id="password" name="password" required value="abcd1234">
                </div>
                <input type="hidden" name="remember" id="remember" value="on">

                <button class="btn btn-block blue-gradient mt-1 mb-1" type="submit">ログイン</button>
              </form>

              <div class="mt-0 h1">
                <a href="{{ route('user.register') }}" class="card-text">ユーザー登録はこちら</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection