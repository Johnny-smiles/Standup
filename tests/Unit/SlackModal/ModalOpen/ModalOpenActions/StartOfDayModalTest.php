<?php

namespace Tests\Unit\SlackModal\ModalOpen\ModalOpenActions;

use App\Models\Task;
use App\Support\Slack\Requests\SlackDataTransferObject;
use App\Support\Slack\Requests\Triggers\Open\Views\StartOfDayView;
use Tests\TestCase;

class StartOfDayModalTest extends TestCase
{
    /** @test */
    public function it_has_data()
    {
        $task = Task::factory()->create();

        $task->workday->update(['completed' => true]);

        $actual = json_encode((new StartOfDayView())
            ->buildResponse(
                (new SlackDataTransferObject(
                    [
                        'token' => 'TOKEN_ID',
                        'team_id' => $task->workday->channel->team->team_id,
                        'channel_id' => $task->workday->channel->slack_channel_id,
                        'channel_name' => $task->workday->channel->name,
                        'user_id' => $task->user->slack_id,
                        'user_name' => $task->user->name,
                        'trigger_id' => '2501415723682.2258651156659',
                    ]
                ))
                    ->setAndUpdateUser()
                    ->setTeam()
                    ->setWorkday()
            ));

        $this->assertStringContainsString('modal', $actual);
        $this->assertStringContainsString('Plan for the day', $actual);
        $this->assertStringContainsString('plain_text_input', $actual);
        $this->assertStringContainsString('single_task_action', $actual);
        $this->assertStringContainsString('add_task_button', $actual);
        $this->assertStringContainsString('Submit', $actual);
    }
}
