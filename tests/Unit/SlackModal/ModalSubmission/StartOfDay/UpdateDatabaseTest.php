<?php

namespace Tests\Unit\SlackModal\ModalSubmission\StartOfDay;

use App\Models\Workday;
use App\Support\Slack\Requests\SlackDataTransferObject;
use App\Support\Slack\Requests\Triggers\Submit\SubmissionActions\Persist;
use Tests\TestCase;

class UpdateDatabaseTest extends TestCase
{
    protected SlackDataTransferObject $dto;

    public function setUp(): void
    {
        parent::setUp();

        $this->dto = (new SlackDataTransferObject([
            'user' => [
                'id' => ($workday = Workday::factory()->create())->slack_id,
                'name' => $workday->user->name,
            ],
            'trigger_id' => '2501415723682.2258651156659',
            'team' => [
                'id' => $workday->channel->team->team_id,
            ],
            'view' => [
                'state' => [
                    'values' => [
                        'input_with_dispatch_task_0' => [
                            'action_task_0' => [
                                'value' => 'Hello world',
                            ],
                        ],
                        'input_with_dispatch_task_1' => [
                            'action_task_1' => [
                                'value' => 'Its a beautiful day',
                            ],
                        ],
                        'input_with_dispatch_task_2' => [
                            'action_task_2' => [
                                'value' => 'Lets explore',
                            ],
                        ],
                    ],
                ],
                'hash' => 'HASH_ID',
            ],
        ]
        ))
            ->setAndUpdateUser()
            ->setTeam()
            ->setTaskText();
    }

    /** @test */
    public function it_creates_new_workday()
    {
        (new Persist())->handle($this->dto);

        $this->assertDatabaseHas('workdays', [
            'submission_id' => $this->dto->getRequest()['trigger_id'],
        ]);
    }

    /** @test */
    public function it_creates_new_task()
    {
        (new Persist())->handle($this->dto);

        $this->assertDatabaseHas('tasks', ['text' => 'Hello world']);
        $this->assertDatabaseHas('tasks', ['text' => 'Its a beautiful day']);
        $this->assertDatabaseHas('tasks', ['text' => 'Lets explore']);
    }
}
