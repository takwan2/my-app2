<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログインフォーム</title>
    @vite(['resources/sass/login.scss', 'resources/js/app.js'])
</head>
<body>

<form class="form-signin" method="POST" action="{{ route('login') }}">
  @csrf
  <h1 class="h3 mb-3 font-weight-normal">ログインフォーム</h1>
  @if ($errors->any())
    @foreach ($errors->all() as $error)
      <div class="alert alert-danger">
          <ul>
              <li>{{ $error }}</li>
          </ul>
        </div>
    @endforeach
  @endif

  <x-alert type="danger" :session="session('danger')"/>

  <!-- <label for="inputEmail" class="sr-only">Email address</label> -->
  <input id="inputEmail" name="nickname" class="form-control" placeholder="Nickname" autofocus>
  <!-- <label for="inputPassword" class="sr-only">Password</label> -->
  <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password">
  <button class="btn btn-lg btn-primary btn-block" type="submit">ログイン</button>
</form>

</body>
</html>