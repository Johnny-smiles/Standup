<?php

namespace Tests\Unit\SlackModal\ModalUpdate\EndOfDay\UpdateActions;

use App\Models\Task;
use App\Support\Slack\Requests\SlackDataTransferObject;
use App\Support\Slack\Requests\Triggers\Update\Views\EndOfDayView;
use Tests\TestCase;

class StatusUpdateTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->task = Task::factory()->create();
    }

    /** @test */
    public function it_adds_complete_status_to_task()
    {
        $this->requestBuilder('completed');

        $this->assertDatabaseHas('tasks', ['status' => 'completed']);
    }

    /** @test */
    public function it_adds_blocked_status_to_task()
    {
        $this->requestBuilder('blocked');

        $this->assertDatabaseHas('tasks', ['status' => 'blocked']);
    }

    /** @test */
    public function it_adds_in_progress_status_to_task()
    {
        $this->requestBuilder('in_progress');

        $this->assertDatabaseHas('tasks', ['status' => 'in_progress']);
    }

    /** @test */
    public function it_adds_delete_status_to_task()
    {
        $this->requestBuilder('delete');

        $this->assertDatabaseHas('tasks', ['status' => 'delete']);
    }

    public function requestBuilder($status)
    {
        return (new EndOfDayView())->buildResponse(
            (new SlackDataTransferObject(
                [
                    'user' => [
                        'id' => $this->task->user->slack_id,
                        'name' => $this->task->user->name,
                    ],
                    'team' => [
                        'id' => $this->task->workday->channel->team->team_id,
                    ],
                    'view' => [
                        'id' => 'V02UDNHULAZ',
                        'hash' => 'HASH_ID',
                    ],
                    'actions' => [
                        0 => [
                            'type' => 'static_select',
                            'action_id' => 'status',
                            'block_id' => 'elements_1',
                            'selected_option' => [
                                'value' => $status,
                            ],
                        ],
                    ],
                ]
            ))
                ->setAndUpdateUser()
                ->setTeam()
                ->setWorkday()
        );
    }
}
