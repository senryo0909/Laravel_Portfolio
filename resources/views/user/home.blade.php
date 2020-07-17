@extends('layouts.user.app')

@section('content')

<h1>ようこそ！{{ Auth::user()->name }}さん！</h1>
<div>
<div><a href="{{ route('user.shifts.index') }}">勤怠管理</a></div>
<div><a href="#">タスク管理</div>
</div>
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
