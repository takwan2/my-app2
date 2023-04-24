<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <div class="navbar-brand">シフト管理</div>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav me-auto">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{ route('home') }}">ホーム</a>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    プロファイル
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="{{ route('edit', ['id' => Auth::user()->id]) }}">マイプロファイル</a></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="dropdown-item">ログアウト</button>
                        </form>
                    </li>
                </ul>
            </li>
            @foreach(Auth::user()->roles as $role)
                @if($role->name=='admin')
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        管理機能
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink2">
                        <li><a class="dropdown-item" href="{{ route('users') }}">ユーザー一覧</a></li>
                        <li><a class="dropdown-item" href="{{ route('shift') }}">シフト編集</a></li>
                    </ul>
                </li>
                @endif
            @endforeach
        </ul>
    </div>
  </div>
</nav>