<?php

namespace Tests\Unit\Controllers;

use App\Models\Task;
use App\Models\User;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    protected Task $task;

    public function setUp(): void
    {
        parent::setUp();

        $this->task = Task::factory()->completed()->create();
    }

    /** @test */
    public function it_redirects_to_workday_view()
    {
        $this->actingAs($this->task->user);

        $this
            ->post(route('task.update', ['task' => $this->task]), [
                'text' => 'Update message',
                'status' => 'completed',
            ])
            ->assertViewIs('pages.workday');

        $this->assertDatabaseHas('tasks', ['text' => 'Update message']);
    }

    /** @test */
    public function it_redirects_to_home_page_after_searching()
    {
        $this->actingAs($this->task->user);

        $this
            ->post(route('task.search'), ['text' => $this->task->text])
            ->assertViewHas(['tasks' => Task::all()]);
    }

    /** @test */
    public function it_redirects_to_workday_view_after_deleting_workday()
    {
        $this->actingAs($this->task->user);

        $newTask = Task::factory()->create([
            'user_id' => $this->task->user->getKey(),
            'workday_id' => $this->task->workday->getKey(),
        ]);

        $this
            ->post(route('task.delete', ['task' => $newTask]))
            ->assertViewIs('pages.workday')
            ->assertViewHas(['workday' => $this->task->workday]);
    }

    /** @test */
    public function guest_cannot_delete_a_task()
    {
        $this
            ->post(route('task.delete', ['task' => $this->task]))
            ->assertRedirect(route('slack.landing'));
    }

    /** @test */
    public function user_can_delete_their_task()
    {
        $this->actingAs($this->task->user);

        $this
            ->post(route('task.delete', ['task' => $this->task]))
            ->assertViewIs('pages.workday')
            ->assertViewHas(['workday' => $this->task->workday]);

        $this->assertDatabaseMissing('tasks', ['id' => $this->task->getKey()]);
    }

    /** @test */
    public function admin_can_delete_any_workday()
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user);

        $this
            ->post(route('task.delete', ['task' => $this->task]))
            ->assertViewIs('pages.workday')
            ->assertViewHas(['workday' => $this->task->workday]);

        $this->assertDatabaseMissing('tasks', ['id' => $this->task->getKey()]);
    }
}
