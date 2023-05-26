<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(2)->create();

        \App\Models\User::factory()->create([
            'nickname' => '田辺 直子',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'locked_flg' => 0,
            'error_count' => 0,
            'created_at' => '2023-02-21 22:40:36',
            'updated_at' => '2023-02-21 22:40:36',
        ]);

        \App\Models\User::factory()->create([
            'nickname' => '渡辺 結衣',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'locked_flg' => 0,
            'error_count' => 0,
            'created_at' => '2023-02-21 22:40:36',
            'updated_at' => '2023-02-21 22:40:36',
        ]);

        \App\Models\User::factory()->create([
            'nickname' => '村山 涼平',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'locked_flg' => 0,
            'error_count' => 0,
            'created_at' => '2023-02-21 22:40:36',
            'updated_at' => '2023-02-21 22:40:36',
        ]);

        \App\Models\Role::factory()->create([
            'name' => 'admin',
            'created_at' => '2023-02-21 22:40:36',
            'updated_at' => '2023-02-21 22:40:36',
        ]);

        $dt = Carbon::now();
        for ($i = 0; $i < 3; $i++) {
            $date = $dt->copy()->startOfWeek()->addWeek($i);
            for ($j = 0; $j < 7; $j++) {
                \App\Models\Day::factory()->create([
                    'date' => $date->copy()->startOfWeek()->addDay($j)->format('Y-m-d'),
                    'created_at' => '2023-02-21 22:40:36',
                    'updated_at' => '2023-02-21 22:40:36',
                ]);
            }
        }

        $this->call([
            DayUserTableSeeder::class,
        ]);

        $this->call([
            LatestShiftTableSeeder::class,
        ]);

        $this->call([
            RoleUserTableSeeder::class,
        ]);
    }
}
