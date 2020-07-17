@extends('layouts.admin.app')
@section('content')
<main class="text-center">
<h1>ようこそ！{{ Auth::user()->name }}さん！</h1>
<div>
    <div class="mb-2 mt-2">
        <a href="{{ route('admin.approval.index') }}">勤怠チェック</a>
    </div>
    <div>
        <a href="#">Taskチェック（作成中）</a>
    </div>
</div>
</main>
<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    You are logged in! 
                </div>
            </div>
        </div>
    </div>
</div> -->
@endsection
