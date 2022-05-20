<?php

namespace Tests\Unit\SlackModal\ModalSubmission\Welcome;

use App\Models\Channel;
use App\Models\User;
use App\Support\Slack\Requests\SlackDataTransferObject;
use App\Support\Slack\Requests\Triggers\Submit\Views\WelcomeView;
use Tests\TestCase;

class ActionTest extends TestCase
{
    protected User $user;
    protected Channel $channel;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([]);

        $this->channel = Channel::factory()->create();
    }

    /** @test */
    public function it_updates_workday_status()
    {
        (new WelcomeView())->buildResponse(
            (new SlackDataTransferObject(
                [
                    'user' => [
                        'id' => $this->user->slack_id,
                        'name' => $this->user->name,
                    ],
                    'trigger_id' => '2501415723682.2258651156659',
                    'team' => [
                        'id' => $this->channel->team->team_id,
                    ],
                    'view' => [
                        'state' => ['values' => []],
                    ],
                ]
            ))
                ->setAndUpdateUser()
                ->setTeam()
        );

        $this->assertDatabaseHas('workdays', ['completed' => 'true']);
    }

    /** @test */
    public function it_creates_welcome_task()
    {
        (new WelcomeView())->buildResponse(
            (new SlackDataTransferObject(
                [
                    'user' => [
                        'id' => $this->user->slack_id,
                        'name' => $this->user->name,
                    ],
                    'trigger_id' => '2501415723682.2258651156659',
                    'team' => [
                        'id' => $this->channel->team->team_id,
                    ],
                    'view' => [
                        'state' => ['values' => []],
                    ],
                ]
            ))
                ->setAndUpdateUser()
                ->setTeam()
        );

        $this->assertDatabaseHas('tasks', ['text' => 'Welcome!']);
    }

    /** @test */
    public function construct_return_message()
    {
        $actual = json_encode((new WelcomeView())->buildResponse(
            (new SlackDataTransferObject(
                [
                    'user' => [
                        'id' => $this->user->slack_id,
                        'name' => $this->user->name,
                    ],
                    'trigger_id' => '2501415723682.2258651156659',
                    'team' => [
                        'id' => $this->channel->team->team_id,
                    ],
                    'view' => [
                        'state' => ['values' => []],
                    ],
                ]
            ))
                ->setAndUpdateUser()
                ->setTeam()
        ));

        $this->assertStringContainsString($this->user->name, $actual);
        $this->assertStringContainsString($this->channel->slack_channel_id, $actual);
        $this->assertStringContainsString('Fantastic '.$this->user->name.'! Lets get started!', $actual);
        $this->assertStringContainsString('Simply type *\/standup* again to create your first workday.', $actual);
    }
}
