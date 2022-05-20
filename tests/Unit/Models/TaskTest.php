<?php

namespace Tests\Unit\Models;

use App\Models\Task;
use App\Models\Workday;
use Tests\TestCase;

class TaskTest extends TestCase
{
    protected Workday $workday;

    public function setUp(): void
    {
        parent::setUp();
        $this->workday = Workday::factory()->create([]);
    }

    /** @test */
    public function it_belongs_to_a_workday()
    {
        $task = Task::factory()->create([
            'workday_id' => $this->workday->getKey(),
            'user_id' => $this->workday->user->getKey(),
        ]);

        $results = $this->workday->tasks->fresh();

        $this->assertTrue($results->contains($task));
    }

    /** @test */
    public function it_belongs_to_a_user()
    {
        $task = Task::factory()->create([
            'user_id' => $this->workday->user->getKey(),
            'workday_id' => $this->workday->getKey(),
        ]);

        $results = $task->user;

        $this->assertTrue($results->is($this->workday->user));
    }
}
