<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DayUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $users = \App\Models\User::all();
        $days = \App\Models\Day::all();

        foreach($users as $user) {
            foreach($days as $day) {
                DB::table('day_user')->insert([
                    ['user_id' => $user->id, 'day_id' => $day->id, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ]); 
            }
        }

    }
}
