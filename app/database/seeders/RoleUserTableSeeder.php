<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = \App\Models\User::find(2);
        $adminrole = \App\Models\Role::find(1);

        DB::table('role_user')->insert([
            ['user_id' => $user->id, 'role_id' => $adminrole->id, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]); 

    }
}
