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
            \Session::flash('err_msg', 'データがありません');
            // return redirect(route('home'));
            // return redirect(route('home2'))->with('danger', 'そんな日はない！');
            // return redirect(route('home2'));
        }

        // dd($day);
        return view('day.day', [
            'day' => $day,
        ]);
    }
    
}
