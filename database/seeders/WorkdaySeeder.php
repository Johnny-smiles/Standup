<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Workday;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class WorkdaySeeder extends Seeder
{
    protected Collection $users;

    public function __construct()
    {
        $this->users = User::all();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->users->each(function ($user) {
            $user->teams->each(function ($team) use ($user) {
                Workday::factory(3)->create([
                    'user_id' => $user->getKey(),
                    'channel_id' => $team->channel->getKey(),
                ]);
            });
        });
    }
}
