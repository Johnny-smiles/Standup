<?php

namespace Tests\Unit\SlackModal\ModalOpen\ModalOpenActions;

use App\Models\Channel;
use App\Models\User;
use App\Support\Slack\Requests\SlackDataTransferObject;
use App\Support\Slack\Requests\Triggers\Open\Views\WelcomeView;
use Tests\TestCase;

class WelcomeModalTest extends TestCase
{
    /** @test */
    public function it_has_data()
    {
        $channel = Channel::factory()->create();

        $user = User::factory()->create();

        $actual = json_encode((new WelcomeView())
            ->buildResponse(
                (new SlackDataTransferObject(
                    [
                        'token' => 'TOKEN_ID',
                        'team_id' => $channel->team->team_id,
                        'channel_id' => $channel->slack_channel_id,
                        'channel_name' => $channel->name,
                        'user_id' => $user->slack_id,
                        'user_name' => $user->name,
                        'trigger_id' => '2501415723682.2258651156659',
                    ]
                ))
                    ->setAndUpdateUser()
                    ->setTeam()
                    ->setWorkday()
            ));

        $this->assertStringContainsString('modal', $actual);
        $this->assertStringContainsString('Welcome!', $actual);
        $this->assertStringContainsString('header', $actual);
        $this->assertStringContainsString('Welcome to Standups', $actual);
        $this->assertStringContainsString('image', $actual);
        $this->assertStringContainsString('standup_url', $actual);
        $this->assertStringContainsString('Create first Workday', $actual);
    }
}
