<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Day;
use App\Models\User;
use App\Models\ShiftBreak;
use App\Models\LatestShift;

class AdminShiftController extends Controller
{

    public function showShiftDay($date)
    {
        $day = Day::where('date', $date)->first();

        if (is_null($day)) {
            return redirect(route('shift'))->with('danger', 'そんな日はない！');
        }

        $userData = [];
        $users = $day->users;

        foreach($users as $user) {
            // dd($user->pivot->start_time);
            $userData[] = ['id' => $user->id, 'name' => $user->nickname, 
            'start_time' => $user->pivot->start_time, 'end_time' => $user->pivot->end_time,];
            // dd(['id' => $user->id, 'name' => $user->nickname, 
            // 'start_time' => $user->pivot->start_time, 'end_time' => $user->pivot->end_time,]);
            // dd($pivot);
        }

        // dd(json_encode($userData));

        return view('shift.edit', [
            'day' => $day,
            'date' => $date,
            'users' => json_encode($userData)
        ]);
    }

    public function shiftUpdate(Request $request) {
        
        // dd($request->json()->all());
        
        foreach($request->json()->all() as $key => $value){
            
            $day = Day::where('date', $request[$key]["date"])->first();
            $day->determined_users()->updateExistingPivot($key, [
                'start_time' => $request[$key]['start_time'], 
                'end_time' => $request[$key]['end_time']
            ]);
            
            $shift = LatestShift::where('day_id', $day->id)->where('user_id', $key)->first();
            $shift_id = $shift->id;
            ShiftBreak::where('shift_id', $shift->id)->delete();

            foreach($request[$key]['break_start_time'] as $key => $value){
                $break = new ShiftBreak;
                $break->shift_id = $shift_id;
                $break->start_time = $key;
                $break->end_time = $key + $value;
                $break->save();
            } 
        }
    }
}
