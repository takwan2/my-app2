<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Day;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    /**
     * カレンダーデータを返却する
     *
     * @return array
     */
    public function getWeeks()
    {
        //今日の日付
        $dt = Carbon::now();

        $date = $dt->startOfWeek();

        $timeCorrespondence = [
            '09:00', '09:15', '09:30', '09:45', '10:00', '10:15', '10:30', '10:45', 
            '11:00', '11:15', '11:30', '11:45', '12:00', '12:15', '12:30', '12:45', 
            '13:00', '13:15', '13:30', '13:45', '14:00', '14:15', '14:30', '14:45', 
            '15:00', '15:15', '15:30', '15:45', '16:00', '16:15', '16:30', '16:45', 
            '17:00', '17:15', '17:30', '17:45', '18:00', '18:15', '18:30', '18:45', 
            '19:00', '19:15', '19:30', '19:45', '20:00', '20:15', '20:30', '20:45', 
            '21:00', '21:15', '21:30', '21:45', '22:00', '22:15', '22:30', '22:45', 
            '23:00', '23:15', '23:30', '23:45', '24:00', 
        ];

        return view('home', [
            'date' => $date,
            'timeCorrespondence' => $timeCorrespondence
        ]);
    }

    public function showShiftRequest() {

        $dt = Carbon::now();
        $date = $dt->startOfWeek()->addWeek(2);

        $user = User::find(auth()->user()->id);

        $days = $user->days;

        return view('request', [
            'date' => $date,
            'days' => $days
        ]);
    }

    public function dateReserve(Request $request) {

        $dt = Carbon::now();
        $date = $dt->startOfWeek()->addWeek(2);

        for($i = 0; $i < 7; $i++) {
            $day = $date->copy()->addDay($i)->format('Y-m-d');
            $d = Day::where('date', '=', $day)->first();

            $d->users()->updateExistingPivot(auth()->user()->id, [
                'start_time' => $request[$day]['start_time'], 
                'end_time' => $request[$day]['end_time']
            ]);
        }
    }
}
