@extends('layout')
@section('title', 'ホーム画面')
@section('script')
    @vite(['resources/sass/home.scss', 'resources/js/app.js'])
@endsection
@section('content')
<div class="mt-2">
    <x-alert type="success" :session="session('success')"/>
    <h3 class="mt-5">今週のシフト</h3>
    <table class="weektable mt-5" >
        <tr>
            <th class="border">月</th>
            <th class="border">火</th>
            <th class="border">水</th>
            <th class="border">木</th>
            <th class="border">金</th>
            <th class="border">土</th>
            <th class="border">日</th>
        </tr>
        <tr>
            @php
                $days = Auth::user()->determined_days
            @endphp
            @for($i = 0; $i < 7; $i++)
                @if(isset($days[$i]->pivot->start_time) && isset($days[$i]->pivot->end_time))
                    <td class="border"><a href="/day/{{ $date->copy()->addDay($i)->format('Y-m-d') }}">{{ $date->copy()->addDay($i)->format('m/d') }}</a><br><br>
                    {{ $timeCorrespondence[$days[$i]->pivot->start_time] }} ~ {{ $timeCorrespondence[$days[$i]->pivot->end_time] }}</td>
                @else
                    <td class="border"><a href="/day/{{ $date->copy()->addDay($i)->format('Y-m-d') }}">{{ $date->copy()->addDay($i)->format('m/d') }}</a></td>
                @endif
            @endfor
        </tr>
    </table>
    <h3 class="mt-5">来週のシフト</h3>
    <table class="weektable mt-5" >
        <tr>
            <th class="border">月</th>
            <th class="border">火</th>
            <th class="border">水</th>
            <th class="border">木</th>
            <th class="border">金</th>
            <th class="border">土</th>
            <th class="border">日</th>
        </tr>
        <tr>
            @php
                $days = Auth::user()->determined_days
            @endphp
            @for($i = 7; $i < 14; $i++)
                @if(isset($days[$i]->pivot->start_time) && isset($days[$i]->pivot->end_time))
                    <td class="border"><a href="/day/{{ $date->copy()->addDay($i)->format('Y-m-d') }}">{{ $date->copy()->addDay($i)->format('m/d') }}</a><br><br>
                    {{ $timeCorrespondence[$days[$i]->pivot->start_time] }} ~ {{ $timeCorrespondence[$days[$i]->pivot->end_time] }}</td>
                @else
                    <td class="border"><a href="/day/{{ $date->copy()->addDay($i)->format('Y-m-d') }}">{{ $date->copy()->addDay($i)->format('m/d') }}</a></td>
                @endif
            @endfor
        </tr>
    </table>
    <button class="btn btn-outline-secondary mt-5" onclick="location.href='{{ route('request') }}' ">再来週（{{$date->copy()->addWeek(2)->format('m/d')}}~）のシフトを提出する</button>
</div>
@endsection