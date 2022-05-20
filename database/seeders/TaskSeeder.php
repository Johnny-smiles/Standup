<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\Workday;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class TaskSeeder extends Seeder
{
    protected Collection $workdays;

    public function __construct()
    {
        $this->workdays = Workday::all();
    }

    public function run()
    {
        $this->workdays->each(function (Workday $workday) {
            $tasksName = ['Slack', 'Garb', 'Workie'];
            shuffle($tasksName);
            Task::factory(3)->create([
                'workday_id' => $workday->getKey(),
                'user_id' => $workday->user->getKey(),
                'text'=> $tasksName[array_rand($tasksName)],
            ]);
        });
    }
}
