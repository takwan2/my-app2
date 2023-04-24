@extends('layout')
@section('title', 'ユーザー編集')
@section('content')
<form method="POST" action="{{ route('update') }}">
  @csrf
  <input type="hidden" name="id" value="{{$user->id}}">
  <div class="mb-3">
    <label for="nickname" class="form-label">ニックネーム</label>
    <input type="text" name="nickname" class="form-control" id="nickname" value="{{$user->nickname}}" disabled>
    @if ($errors->has('nickname'))
        <div class="text-danger">
            {{ $errors->first('nickname') }}
        </div>
    @endif
  </div>
  <div class="mb-3">
    <label for="InputPassword" class="form-label">新しいパスワード</label>
    <input type="password" name="password" class="form-control" id="InputPassword">
    @if ($errors->has('password'))
        <div class="text-danger">
            {{ $errors->first('password') }}
        </div>
    @endif
  </div>
  @foreach($user->roles as $role)
    @if($role->name=='admin')
    <div class="mb-3">
      <label for="lock" class="form-label">ロック有効</label>
      <input type="hidden" name="locked_flg" value="0" id="lock">
      <input type="checkbox"  name="locked_flg" id="lock" value="1" @if($user->locked_flg === 1) echo checked="checked" @endif>
    </div>
    @endif
  @endforeach
  <button type="submit" class="btn btn-primary">更新する</button>
</form>
@foreach($user->roles as $role)
  @if($role->name=='admin')
  <form method="POST" action="{{ route('delete', $user->id) }}">
    @csrf
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
      <button type="submit" class="btn btn-danger" onclick="return confirm('本当に削除しますか?')">削除する</button>
    </div>
  </form>
  @endif
@endforeach
@endsection