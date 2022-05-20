<?php

namespace Tests\Feature\EndOfDay;

use App\Models\Task;
use App\Support\GitHub\Blueprints\Stubs\GithubResponse;
use App\Support\GitHub\Services\GitHub;
use App\Support\Slack\Blueprints\Stubs\EndOfDay\ModalTriggerStub;
use App\Support\Slack\Blueprints\Stubs\EndOfDay\UpdateActionStubs;
use App\Support\Slack\Services\Slack;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class SlackDataWithGitHubTest extends TestCase
{
    protected Task $task;

    protected function setUp(): void
    {
        parent::setUp();

        $this->task = Task::factory()->completed()->create();

        $this->task->workday->user->update([
            'github_token' => 'XOXO',
        ]);
    }

    /** @test */
    public function it_opens_a_modal()
    {
        GitHub::shouldReceive('githubIssuesQuery')
            ->once()
            ->andReturns(json_encode(GithubResponse::responseFromGitHubIssuesQuery()));

        Slack::shouldReceive('openModal')
            ->withArgs(fn ($args) => $args === ModalTriggerStub::responseEndOfDayFromSlackWithGitHubIssues($this->task))
            ->once();

        $this->post(
            route(
                'standups.index',
                ModalTriggerStub::requestEndOfDayFromSlack($this->task)
            )
        );
    }

    /** @test */
    public function it_updates_a_modal()
    {
        $this->task->update(['status' => 'completed']);

        Cache::put(
            $this->task->workday->user->getKey().'.github-issues',
            GithubResponse::responseFromGitHubIssuesQuery()['data']['viewer']['issues']['nodes']
        );

        Slack::shouldReceive('updateModal')
            ->withArgs(fn ($args) => $args === UpdateActionStubs::responseToSlackWithGitHubIssues())
            ->once();

        $this->post(
            route(
                'standups.index',
                UpdateActionStubs::requestFromSlack($this->task)
            )
        );
    }
}
