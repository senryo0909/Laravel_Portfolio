<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            .main{
                text-align: center;
            }
            
        </style>
    </head>
    <body>
        <main class="main">
            <h1>ようこそ業務管理アプリへ</h1>
            <div>
                <p>従業員はこちら</p>
                <a href="{{ route('user.login') }}">ログイン</a>
            </div>
            <div>
                <p>管理者はこちら</p>
                <a href="{{ route('admin.login') }}">ログイン</a>
            </div>
        </main>
        