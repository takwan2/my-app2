<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Day;
use App\Models\User;

class TestController extends Controller
{
    //

    public function test()
    {
        
        return view('test');
    }

    public function test2()
    {
        
        return view('test2');
    }
    
}