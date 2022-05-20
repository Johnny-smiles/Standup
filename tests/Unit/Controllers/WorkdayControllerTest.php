<?php

namespace Tests\Unit\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Workday;
use Tests\TestCase;

class WorkdayControllerTest extends TestCase
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
            ->get(route('workday.show', ['workday' => $this->task->workday]))
            ->assertViewIs('pages.workday')
            ->assertViewHas(['workday' => $this->task->workday]);
    }

    /** @test */
    public function it_redirects_to_home_page_after_searching_not_found()
    {
        $this->actingAs($this->task->user);

        $this
            ->post(route('workday.search'), [
                'data' => $this->task->workday,
            ])
            ->assertRedirect(route('alert',
                [
                    'alert' => 'Workday',
                    'message' => 'Workday',
                    'action' => 'Not Found',
                ]
            ));
    }

    /** @test */
    public function it_redirects_to_workday_view_after_deleting_workday()
    {
        $this->actingAs($this->task->user);

        Workday::factory()->create([
            'user_id' => $this->task->user,
        ]);

        $this
            ->post(route('workday.delete', ['workday' => $this->task->workday]))
            ->assertViewIs('pages.workday')
            ->assertViewHas(['workday' => $this->task->user->workdays()->latest()->first()]);
    }

    /** @test */
    public function guest_cannot_delete_a_workday()
    {
        $this
            ->post(route('workday.delete', ['workday' => $this->task->workday]))
            ->assertRedirect(route('slack.landing'));
    }

    /** @test */
    public function unauth_user_cannot_delete_workday()
    {
        $this
            ->post(route('workday.delete', ['workday' => Workday::factory()->create()]))
            ->assertRedirect(route('slack.landing'));
    }

    /** @test */
    public function user_can_delete_their_workday()
    {
        $this->actingAs($this->task->user);

        $this
            ->post(route('workday.delete', ['workday' => $this->task->workday]))
            ->assertRedirect(route('alert',
                [
                    'alert' => 'Workday',
                    'message' => 'Workday',
                    'action' => 'Deleted',
                ]
            ));

        $this->assertDatabaseMissing('workdays', [
            'id' => $this->task->workday->getKey(),
        ]);
    }

    /** @test */
    public function admin_can_delete_any_workday()
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user);

        $this
            ->post(route('workday.delete', ['workday' => $this->task->workday]))
            ->assertRedirect(route('alert',
                [
                    'alert' => 'Workday',
                    'message' => 'Workday',
                    'action' => 'Deleted',
                ]
            ));

        $this->assertDatabaseMissing('workdays', [
            'id' => $this->task->workday->getKey(),
        ]);
    }
}
