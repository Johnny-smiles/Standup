<?php

namespace Tests\Feature\Welcome;

use App\Models\Channel;
use App\Models\User;
use App\Support\Slack\Blueprints\Stubs\Welcome\ModalTriggerStub;
use App\Support\Slack\Blueprints\Stubs\Welcome\SubmissionStub;
use App\Support\Slack\Blueprints\Stubs\Welcome\WelcomeUpdateStub;
use App\Support\Slack\Services\Slack;
use Tests\TestCase;

class SlackDataTest extends TestCase
{
    protected User $user;
    protected Channel $channel;

    protected function setUp(): void
    {
        parent::setUp();

        $this->channel = Channel::factory()->create();

        $this->user = User::factory()->create();
    }

    /** @test */
    public function it_opens_a_modal()
    {
        Slack::shouldReceive('openModal')
            ->withArgs(fn ($args) => $args === ModalTriggerStub::responseWelcomeToSlack($this->channel, $this->user))
            ->once();

        $this->post(
            route(
                'standups.index',
                ModalTriggerStub::requestWelcomeFromSlack(
                    $this->channel,
                    $this->user
                )
            )
        );
    }

    /** @test */
    public function it_updates_a_modal()
    {
        Slack::shouldReceive('updateModal')
            ->withArgs(fn ($args) => $args === WelcomeUpdateStub::responseToSlack($this->channel, $this->user))
            ->once();

        $this->post(
            route(
                'standups.index',
                WelcomeUpdateStub::requestFromSlack(
                    $this->channel,
                    $this->user
                )
            )
        );
    }

    /** @test */
    public function it_renders_a_response_message()
    {
        Slack::shouldReceive('postEphemeralMessage')
            ->withArgs(fn ($args) => $args === SubmissionStub::messageStructureResponse($this->channel, $this->user))
            ->once();

        $this->post(
            route(
                'standups.index',
                SubmissionStub::requestFromSlack($this->channel, $this->user)
            )
        );
    }

    /** @test */
    public function unregistered_slack_id_will_create_new_user()
    {
        Slack::shouldReceive('openModal')->once();

        $this->post(
            route(
                'standups.index',
                [
                    'team_id' => $this->channel->team->team_id,
                    'channel_id' => $this->channel->slack_channel_id,
                    'channel_name' => $this->channel->name,
                    'user_id' => 'SlackId',
                    'user_name' => 'SlackUserName',
                    'trigger_id' => 'TRIGGER_ID',
                ]
            )
        );

        $this->assertDatabaseHas('users', [
            'slack_id' => 'SlackId',
            'slack_username' => 'SlackUserName',
        ]);
    }

    /** @test */
    public function admin_user_will_updated_team_response_channel()
    {
        $this->user->update(['is_admin' => true]);

        $this->post(
            route(
                'standups.index',
                [
                    'team_id' => $this->channel->team->team_id,
                    'channel_id' => 'SlackChannelId',
                    'channel_name' => 'SlackChannelName',
                    'user_id' => $this->user->slack_id,
                    'user_name' => $this->user->slack_username,
                    'trigger_id' => 'TRIGGER_ID',
                ]
            )
        );

        $this->assertDatabaseHas('channels', [
            'slack_channel_id' => 'SlackChannelId',
            'name' => 'SlackChannelName',
        ]);
    }
}
