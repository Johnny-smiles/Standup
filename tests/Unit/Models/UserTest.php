<?php

namespace Tests\Unit\Models;

use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use App\Models\Workday;
use Tests\TestCase;

class UserTest extends TestCase
{
    protected User $user;
    protected Task $task;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->task = Task::factory()->create();
    }

    /** @test */
    public function it_belongs_to_many_teams()
    {
        $teams = Team::factory()->count(2)->create();
        $this->user->teams()->attach([
            $teams[0]->getKey(),
            $teams[1]->getKey(),
        ]);

        $results = $this->user->teams;

        foreach ($teams as $team) {
            $this->assertTrue($results->contains($team));
        }
    }

    /** @test */
    public function it_has_many_tasks()
    {
        $tasks = Task::factory()->count(2)->create([
            'user_id' => $this->user->getKey(),
            'workday_id' => $this->task->workday->getKey(),
        ]);

        $results = $this->user->tasks->fresh();

        foreach ($tasks as $task) {
            $this->assertTrue($results->contains($task));
        }
    }

    /** @test */
    public function it_has_many_workdays()
    {
        $workdays = Workday::factory()->count(2)->create([
            'channel_id' => $this->task->workday->channel->getKey(),
            'user_id' => $this->user->getKey(),
        ]);

        $results = $this->user->workdays->fresh();

        foreach ($workdays as $workday) {
            $this->assertTrue($results->contains($workday));
        }
    }
}
