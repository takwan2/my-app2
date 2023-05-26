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
    public function getHome()
    {
        //今日の日付
        $dt = Carbon::now();

        $user = Auth::user();
        $isAdmin = false;
        
        foreach($user->roles as $role){
            if($role->name=='admin'){
                $isAdmin = true;
            }
        }

        return view('home', [
            'isAdmin'=> $isAdmin
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
