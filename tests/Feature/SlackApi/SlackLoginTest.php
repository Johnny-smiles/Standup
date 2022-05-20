<?php

namespace Tests\Feature;

use App\Http\Controllers\SlackLoginController;
use App\Models\User;
use App\Support\Slack\Services\SlackJSONWebTokenDecoder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SlackLoginTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Http::fake([
            'slack.com/*' => Http::response([
                'ok' => true,
                'access_token' => 'xoxo',
                'token_type' => 'Bearer',
                'id_token' => 'token',
            ], 200),

        ]);

        $mock = $this->createMock(SlackJSONWebTokenDecoder::class);

        $mock->method('handle')
            ->willReturn([
                'https://slack.com/user_id' => 'SlackId',
                'name' => 'Johnny Smiles',
                'email' => 'Jsmiles@gmail.com',
                'picture' => 'googlePics.com',
            ]);

        app()->bind(SlackJSONWebTokenDecoder::class, fn () => $mock);
    }

    /** @test */
    public function auth_cannot_redirect_to_slack_login()
    {
        $mock = \Mockery::mock(SlackLoginController::class, (new Request()));

        $mock->shouldReceive('loginRedirect')->never();

        app()->bind(SlackLoginController::class, fn () => $mock);

        $user = User::factory()->create();
        $this->actingAs($user);
        $this->get(route('slack.redirect'))->assertRedirect('home');
    }

    /** @test */
    public function auth_cannot_redirect_to_slack_callback()
    {
        $mock = \Mockery::mock(SlackLoginController::class, (new Request()));

        $mock->shouldReceive('oAuthCallback')->never();

        app()->bind(SlackLoginController::class, fn () => $mock);

        $user = User::factory()->create();
        $this->actingAs($user);
        $this->get(route('slack.callback'))->assertRedirect('home');
    }

    /** @test */
    public function new_user_can_auth_with_slack()
    {
        $this->get(route('slack.redirect').'?code=test');

        $user = User::where([
            'slack_id' => 'SlackId',
            'name' => 'Johnny Smiles',
            'email' => 'Jsmiles@gmail.com',
            'avatar' => 'googlePics.com',
        ])->firstOrFail();

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function existing_user_can_auth_with_slack()
    {
        User::factory()->create([
            'slack_id' => 'SlackId',
        ]);

        $this->get(route('slack.redirect').'?code=test');

        $user = User::where([
            'slack_id' => 'SlackId',
        ])->firstOrFail();

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function existing_user_null_data_updated()
    {
        User::factory()->create([
            'slack_id' => 'SlackId',
            'slack_username' => 'Johnny Smiles',
        ]);

        $this->get(route('slack.redirect').'?code=test');

        $this->assertDatabaseHas('users', [
            'slack_id' => 'SlackId',
            'slack_username' => 'Johnny Smiles',
            'email' => 'Jsmiles@gmail.com',
            'avatar' => 'googlePics.com',
        ]);
    }
}
