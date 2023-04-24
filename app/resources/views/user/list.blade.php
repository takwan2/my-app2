@extends('layout')
@section('title', 'ユーザ一覧')
@section('content')
@if(session('danger'))
<div class="alert alert-danger">
    {{ session('danger') }}
</div>
@endif
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif
<table>
    <tr>
        <th>ニックネーム</th>
        <!-- <th>ロック状態</th> -->
        <th>詳細</th>
    </tr>
    @foreach($users as $user)
    <tr>
        <td>{{ $user->nickname }}</td>
        <!-- <td>{{ $user->locked_flg }} -->
        <td><a href="/user/edit/{{ $user->id }} ">編集</a></td>
    </tr>
    @endforeach
</table>
@endsection