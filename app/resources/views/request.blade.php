@extends('layout')
@section('title', '再来週の希望シフト')
@section('script')
    @vite(['resources/sass/request.scss', 'resources/js/request_bk.js'])
@endsection
@section('content')
<div class="container">
    <table class="weektable mt-5" >
        <tr>
            <th class="border" width="100px"></th>
            <th class="border time" width="20px">9</th>
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
        @for($i = 0; $i < 7; $i++)
        <tr id="{{ $date->copy()->addDay($i)->format('Y-m-d') }}">
            <th class="border">{{ $date->copy()->addDay($i)->format('m/d') }}</th>
            @for ($j = 0; $j <= 60; $j++)
                @if (!is_null($days[$i+14]->pivot->start_time) && !is_null($days[$i+14]->pivot->end_time) && $j >= $days[$i+14]->pivot->start_time && $j <= $days[$i+14]->pivot->end_time)
                    <th class="border highlighted" width="20px" id="{{$i}}-{{$j}}"></th>
                @else
                    <th class="border" width="20px" id="{{$i}}-{{$j}}"></th>
                @endif
            @endfor
        </tr>
        @endfor
    </table>
    @csrf
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <button id="update" class="btn btn-primary mt-4">更新する</button>
</div>
<script>
    @php
    $dates = [];
    for($i = 0; $i < 7; $i++){
        $tmpDate = $date->copy()->addDay($i)->format('Y-m-d');
        $dates[] = $tmpDate;
    }
    @endphp
    const dates = @json($dates);
</script>
@endsection