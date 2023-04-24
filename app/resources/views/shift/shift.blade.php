@extends('layout')
@section('title', 'シフト編集')
@section('script')
    @vite(['resources/sass/home.scss', 'resources/js/app.js'])
@endsection
@section('content')
<div class="mt-2">
    <p class="mt-5">編集したい日をクリックしてください。</p>
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
        @for($i = 0; $i < 3; $i++)
        <tr>
            @for($j = 0; $j < 7; $j++)
            <td class="border"><a href="/shift/{{ $date->copy()->addDay(($i*7)+$j)->format('Y-m-d') }}">{{ $date->copy()->addDay(($i*7)+$j)->format('m/d') }}</a></td>
            @endfor
        </tr>
        @endfor
    </table>
</div>
@endsection