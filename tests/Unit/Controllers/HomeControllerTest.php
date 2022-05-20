<?php

namespace Tests\Unit\Controllers;

use App\Models\Task;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    protected Task $task;

    public function setUp(): void
    {
        parent::setUp();

        $this->task = Task::factory()->completed()->create();

        $this->actingAs($this->task->user);
    }

    /** @test */
    public function it_redirects_to_home_view()
    {
        $response = $this->get(route('home'));

        $response->assertViewIs('pages.home')
            ->assertViewHas(['user' => $this->task->user])
            ->assertViewHas('completedTasks')
            ->assertViewHas('blockedTasks')
            ->assertViewHas('inProgressTasks')
            ->assertViewHas('deletedTasks');
    }

    /** @test */
    public function it_redirects_to_home_alert_view()
    {
        $this
            ->get(route('alert',
                [
                    'alert' => 'Workday',
                    'message' => 'Workday',
                    'action' => 'Not Found',
                ]
            ))
            ->assertViewIs('pages.alert');
    }
}
