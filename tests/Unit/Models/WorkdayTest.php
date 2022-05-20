<?php

namespace Tests\Unit\Models;

use App\Models\Task;
use App\Models\Workday;
use Tests\TestCase;

class WorkdayTest extends TestCase
{
    protected Workday $workday;

    public function setUp(): void
    {
        parent::setUp();
        $this->workday = Workday::factory()->create();
    }

    /** @test */
    public function it_has_many_tasks()
    {
        $tasks = Task::factory()->count(2)->create([
            'workday_id' => $this->workday->getKey(),
            'user_id' => $this->workday->user->getKey(),
        ]);

        foreach ($tasks as $task) {
            $this->assertTrue($this->workday->tasks->fresh()->contains($task));
        }
    }
}
