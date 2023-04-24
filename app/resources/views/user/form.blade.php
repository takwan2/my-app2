@extends('layout')
@section('title', 'ユーザー作成')
@section('content')
@if(session('get_userid_error'))
<div class="alert alert-danger">
    {{ session('get_userid_error') }}
</div>
@endif
<form method="POST" action="{{ route('store') }}">
  @csrf
  <div class="mb-3">
    <label for="nickname" class="form-label">ニックネーム</label>
    <input type="text" name="nickname" class="form-control" id="nickname">
    @if ($errors->has('nickname'))
        <div class="text-danger">
            {{ $errors->first('nickname') }}
        </div>
    @endif
  </div>
  <div class="mb-3">
    <label for="InputPassword" class="form-label">パスワード</label>
    <input type="password" name="password" class="form-control" id="InputPassword">
    @if ($errors->has('password'))
        <div class="text-danger">
            {{ $errors->first('password') }}
        </div>
    @endif
  </div>
  <button type="submit" class="btn btn-primary">作成する</button>
</form>
@endsection