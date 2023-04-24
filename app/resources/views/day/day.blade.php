@extends('layout')
@section('title', $day->date)
@section('content')
@section('script')
    @vite(['resources/sass/day.scss', 'resources/js/app.js'])
@endsection
<h1>{{ $day->date }}のシフト</h1>
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
    <tr id="{{$user->nickname}}">
        <th class="border" width="100px">{{$user->nickname}}</th>
        @php
            $shiftBreaks = $user->shiftBreaks()->get();

            $start_time = isset($user->pivot->start_time) ? $user->pivot->start_time : null;
            $end_time = isset($user->pivot->end_time) ? $user->pivot->end_time : null;
        @endphp      
        @for ($i = 0; $i <= 60; $i++)
            @php
                $highlighted = true;
                foreach($shiftBreaks as $shiftBreak) {
                    if($i >= $shiftBreak->start_time && $i <= $shiftBreak->end_time) {
                        $highlighted = false;
                        break;
                    }
                }
            @endphp
            <th class="border {{ (($start_time !== null && $i >= $start_time) && ($end_time !== null && $i <= $end_time) && $highlighted) ? 'highlighted' : '' }}" width="20px" id="{{$user->id}}-{{$i}}"></th>
        @endfor
    </tr>
    @endforeach
</table>
@endsection