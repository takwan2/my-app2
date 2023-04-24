<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Day;

class DayController extends Controller
{
    //

    public function showDay($date)
    {
        $day = Day::where('date', $date)->first();


        if (is_null($day)) {
            return redirect(route('home'))->with('danger', 'そんな日はない！');
        }

        // dd($day);
        return view('day.day', [
            'day' => $day,
        ]);
    }
    
}
