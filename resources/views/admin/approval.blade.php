@extends('layouts.admin.app')
@section('content')
<main>
<div class="d-flex p-2 justify-content-around">

@if(isset($lists[1]))
<section class="applying d-inline-flex p-2">
    <div>
        <p class="mx-auto">申請中</p>
        <table class="table-bordered">
        <thead>
            <tr>
                <th>名前</th>
                <th>年月</th>
                <th>詳細</th>
                <th>ステータス</th>  
            </tr>
        </thead>
        </tbody>
        @for($i = 0; $i < count($lists[1]); $i++)
            <tr>
                <td>{{ $lists[1][$i]['name'] }}</td>
                <td>{{ $lists[1][$i]['year'] }}</td>
                <td><a href="{{ route('admin.approval.show', ['id' => $lists[1][$i]['id'], 'user' => $lists[1][$i]['name'], 'year' => $lists[1][$i]['year']]) }} " target="_blank">こちら</a></td>
                <td>
                    <select name="applying" id="{{ $lists[1][$i]['id'] }}">
                        <!-- <option value="0">選んでください</option> -->
                        <option selected value="{{ $lists[1][$i]['approval'] }}">申請中</option>
                        <option value="2">差し戻し</option>
                        <option value="3">承認</option>
                    </select>
                </td>
            </tr>
        @endfor
        </table>
        <!-- <button class="mt-2" id="more_1" type="button" value="">追加表示....</button> -->
    </div>
</section>
@elseif(!isset($lists[1]))
<section class="applying d-inline-flex p-2">
    <div>
        <p class="mx-auto">申請中一覧</p>
            <p>申請中のデーターがありません</p>
    </div>
</section>
@endif
@if(isset($lists[2]))
<section class="decline d-inline-flex p-2">
    <div>
    <p class="mx-auto">差し戻し<p>
        <table class="table-bordered">
        <thead>
            <tr>
                <th>名前</th>
                <th>年月</th>
                <th>詳細</th>
                <th>ステータス</th>
            </tr>  
        </thead>
        </tbody>
            @for($i = 0; $i < count($lists[2]); $i++)
            <tr>
                <td>{{ $lists[2][$i]['name']}}</td>
                <td>{{ $lists[2][$i]['year'] }}</td>
                <td><a href="{{ route('admin.approval.show', ['id' => $lists[2][$i]['id'], 'user' => $lists[2][$i]['name'], 'year' => $lists[2][$i]['year']]) }} " target="_blank">こちら</a></td>
                <td>
                    <select name="decline" id="{{ $lists[2][$i]['id'] }}">
                        <!-- <option value="0">選んでください</option> -->
                        <option value="1">申請中</option>
                        <option selected value="{{ $lists[2][$i]['approval'] }}">差し戻し</option>
                        <option value="3">承認</option>
                    </select>
                </td>
            </tr>
            @endfor
            </tbody>
        </table>
        <!-- <button class="mt-2" id="more_2" type="button" value="">追加表示....</button> -->
    </div>
</section>
@elseif(!isset($lists[2]))
<section class="decline d-inline-flex p-2">
    <div>
        <p class="mx-auto">差し戻し一覧</p>
            <p>差し戻し中のデーターがありません</p>
    </div>
</section>
@endif
@if(isset($lists[3]))
<section class="approved d-inline-flex p2">
    <div>
        <p class="mx-auto">承認済み一覧<p>
        <table class="table-bordered">
        <thead>
            <tr>
                <th>名前</th>
                <th>年月</th>
                <th>詳細</th>
                <th>ステータス</th>
                <th>帳票</th>
            </tr>
        </thead>
        </tbody>
            @for($i = 0; $i < count($lists[3]); $i++)
            <tr>
                <td>{{ $lists[3][$i]['name'] }}</td>
                <td>{{ $lists[3][$i]['year'] }}</td>
                <td>
                    <a href="{{ route('admin.approval.show', ['id' => $lists[3][$i]['id'], 'user' => $lists[3][$i]['name'], 'year' => $lists[3][$i]['year']]) }} " target="_blank">こちら</a>                  
                </td>
                <td>
                    <select name="approved" id="{{ $lists[3][$i]['id'] }}">
                        <!-- <option value="0">選んでください</option> -->
                        <option value="1">申請中</option>
                        <option value="2">差し戻し</option>
                        <option selected value="{{ $lists[3][$i]['approval'] }}">承認</option>
                    </select>
                </td>
                <td>
                    <a href="{{ route('admin.pdf', ['id' => $lists[3][$i]['id'], 'user' => $lists[3][$i]['name'], 'year' => $lists[3][$i]['year']]) }} " target="_blank">帳票の作成</a>
                </td>
            </tr>
            @endfor
            </tbody>
        </table>
        <!-- <button class="mt-2" id="more_3" type="button" value="">追加表示....</button> -->
    </div>
</section>
@elseif(!isset($lists[3]))
<section class="approved d-inline-flex p2">
    <div>
        <p class="mx-auto">承認一覧</p>
            <p>承認中のデーターがありません</p>
    </div>
</section>
@endif
</div>
<div class="text-center">
<a class="text-center" href="{{ url()->previous() }}">戻る</a>
</div>
</main>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script> -->
<script src="{{ asset('/js/approve.js') }}"></script>
@endsection