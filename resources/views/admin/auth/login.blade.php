@extends('layout.auth.app')

@section('title', 'ログイン')

@section('content')
<main>
  <div class="container">
    <div class="row">
      <div class="mx-auto col-offset-8">
        <h1 class="text-center h1"><a class="text-dark" href="/">管理者ログイン</a></h1>
        <div class="card mt-3 h-100">
          <div class="card-body text-center">
            <h2 class="h2 card-title text-center mt-5 mb-5">ログイン</h2>
            @include('auth.error_card_list')          
            <div class="card-text">
              <form method="POST" action="{{ route('admin.login') }}">
                @csrf

                <div class="md-form mb-5 mt-5">
                  <label for="email"><p class="h3">メールアドレス</p></label>
                  <input class="form-control" type="text" id="email" name="email" required value="admin@gmail.com{{ old('email') }}">
                </div>

                <div class="md-form mb-5 mt-5">
                  <label for="password"><p class="h2">パスワード</p></label>
                  <input class="form-control" type="password" id="password" name="password" value="admin1234" aequired>
                </div>
                <input type="hidden" name="remember" id="remember" value="on">

                <button class="btn btn-block blue-gradient mt-1 mb-1" type="submit">ログイン</button>
              </form>

              <div class="mt-0 h1">
              <a href="{{ route('admin.register') }}" class="card-text">管理者登録はこちら</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection