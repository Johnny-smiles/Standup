<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ChannelSeeder::class);
        $this->call(UserSeeder::class);
        $teams = Team::all();
        User::all()->each(function ($user) use ($teams) {
            $user->teams()->attach(
                $teams->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
        $this->call(WorkdaySeeder::class);
        $this->call(TaskSeeder::class);
    }
}
