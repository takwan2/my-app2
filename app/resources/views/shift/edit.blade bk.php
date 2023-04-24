@extends('layout')
@section('title', "{$day->date}のシフト編集")
@section('script')
    @vite(['resources/sass/shift.scss', 'resources/js/shiftEdit.js'])
@endsection
@section('content')
<h1>{{ $day->date }}</h1>
<h1 class="mt-3">希望シフト</h1>
<table class="mt-5">
    <tr>
        <th class="border" width="100px">名前</th>
        <th class="border" width="20px">9</th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px">10</th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px">11</th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px">12</th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px">13</th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px">14</th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px">15</th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px">16</th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px">17</th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px">18</th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px">19</th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px">20</th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px">21</th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px">22</th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px">23</th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px">24</th>
    </tr>
    @foreach ($day->users as $user)
    <tr id="{{$user->nickname}}">
        <th class="border" width="100px">{{$user->nickname}}</th>
        @for ($i = 0; $i <= 60; $i++)
            @if (isset($user->pivot->start_time) && isset($user->pivot->end_time) && $i >= $user->pivot->start_time && $i <= $user->pivot->end_time)
                <th class="border highlighted" width="20px"></th>
            @else
                <th class="border" width="20px"></th>
            @endif
        @endfor
    </tr>
    @endforeach
</table>
<h1 class="mt-5">実際のシフト</h1>
<table class="mt-5">
    <tr>
        <th class="border" width="100px">名前</th>
        <th class="border" width="20px">9</th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px">10</th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px">11</th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px">12</th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px">13</th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px">14</th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px">15</th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px">16</th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px">17</th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px">18</th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px">19</th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px">20</th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px">21</th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px">22</th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px">23</th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px"></th>
        <th class="border" width="20px">24</th>
    </tr>
    @foreach ($day->determined_users as $user)
    <tr id="{{$user->id}}">
        <th class="border" width="100px">{{$user->nickname}}</th>
        @for ($i = 0; $i <= 60; $i++)
            @if (isset($user->pivot->start_time) && isset($user->pivot->end_time) && 
            $i >= $user->pivot->start_time && $i <= $user->pivot->end_time)
                <th class="border highlighted" width="20px" id="{{$user->id}}-{{$i}}"></th>
            @else
                <th class="border" width="20px" id="{{$user->id}}-{{$i}}"></th>
            @endif
        @endfor
    </tr>
    @endforeach
    <p>{{$breaks}}</p>
</table>
<meta name="csrf-token" content="{{ csrf_token() }}">
<button id="update" class="btn btn-primary mt-4">更新する</button>
<script>
    @php
    $usersID = [];
    foreach ($day->determined_users as $user) {
        $usersID[] = $user->id;
    }
    @endphp
    const usersID = @json($usersID);
    const date = @json($date);
</script>
@endsection