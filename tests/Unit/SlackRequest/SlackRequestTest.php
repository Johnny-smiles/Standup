<?php

namespace Tests\Unit\SlackRequest;

use App\Models\Workday;
use App\Support\Slack\Requests\Exceptions\MissingNameException;
use App\Support\Slack\Requests\Exceptions\MissingSlackIdException;
use App\Support\Slack\Requests\Exceptions\MissingTeamIdException;
use App\Support\Slack\Requests\SlackRequest;
use Tests\TestCase;
use Tests\Unit\SlackModal\MockBuilder;

class SlackRequestTest extends TestCase
{
    use MockBuilder;

    protected Workday $workday;

    protected function setUp(): void
    {
        parent::setUp();

        $this->workday = Workday::factory()->statusCompleted()->create();
    }

    /** @test */
    public function it_requires_slack_id()
    {
        $this->expectException(MissingSlackIdException::class);

        (new SlackRequest([]))->handle();
    }

    /** @test */
    public function it_requires_slack_user_name()
    {
        $this->expectException(MissingNameException::class);

        (new SlackRequest(['user_id' => 'id']))->handle();
    }

    /** @test */
    public function it_requires_team_id()
    {
        $this->expectException(MissingTeamIdException::class);

        (new SlackRequest([
            'user_id' => 'id',
            'user_name' => 'name',
        ]))->handle();
    }

    /** @test */
    public function it_creates_new_user()
    {
        (new SlackRequest(
            $this->requestBuilder($this->workday)
        ))->handle();

        $this->assertDatabaseHas('users', [
            'slack_id' => $this->workday->user->slack_id,
        ]);
    }

    /** @test */
    public function it_creates_new_channel()
    {
        (new SlackRequest(
            $this->requestBuilder($this->workday)
        ))->handle();

        $this->assertDatabaseHas('channels', [
            'slack_channel_id' => $this->workday->channel->slack_channel_id,
        ]);

        $this->assertDatabaseHas('channels', [
            'name' => $this->workday->channel->name,
        ]);
    }

    /** @test */
    public function it_updates_existing_channel()
    {
        $this->workday->user->update(['is_admin' => true]);

        (new SlackRequest(
            [
                'channel_id' => $this->workday->channel->slack_channel_id,
                'channel_name' => 'channelName',
                'user_id' => $this->workday->user->slack_id,
                'user_name' => $this->workday->user->slack_username,
                'team_id' => $this->workday->channel->team->team_id,
                'trigger_id' => '25014SDF23682.22586511SDF59.64488ed92b33d5SDFSDF5c09cd351be4',
            ]
        ))->handle();

        $this->assertDatabaseHas('channels', [
            'name' => 'channelName',
        ]);
    }

    protected function requestBuilder(Workday $workday): array
    {
        return [
            'channel_id' => $workday->channel->slack_channel_id,
            'channel_name' => $workday->channel->name,
            'user_id' => $workday->user->slack_id,
            'user_name' => $workday->user->slack_username,
            'team_id' => $workday->channel->team->team_id,
            'trigger_id' => '25014SDF23682.22586511SDF59.64488ed92b33d5SDFSDF5c09cd351be4',
        ];
    }
}
