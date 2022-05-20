<?php

namespace Tests\Feature\StartOfDay;

use App\Models\Workday;
use App\Support\GitHub\Blueprints\Stubs\GithubResponse;
use App\Support\GitHub\Services\GitHub;
use App\Support\Slack\Blueprints\Stubs\StartOfDay\AddTaskStub;
use App\Support\Slack\Blueprints\Stubs\StartOfDay\DeleteTaskStub;
use App\Support\Slack\Blueprints\Stubs\StartOfDay\ModalTriggerStub;
use App\Support\Slack\Services\Slack;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class SlackDataWithGitHubIssuesTest extends TestCase
{
    protected Workday $workday;

    protected function setUp(): void
    {
        parent::setUp();

        $this->workday = Workday::factory()->statusCompleted()->create();

        $this->workday->user->update([
            'github_token' => 'XOXO',
        ]);

        Cache::put(
            $this->workday->user->getKey().'.github-issues',
            GithubResponse::responseFromGitHubIssuesQuery()['data']['viewer']['issues']['nodes']
        );
    }

    /** @test */
    public function it_opens_a_modal()
    {
        GitHub::shouldReceive('githubIssuesQuery')
            ->once()
            ->andReturns(json_encode(GithubResponse::responseFromGitHubIssuesQuery()));

        Slack::shouldReceive('openModal')
            ->withArgs(fn ($args) => $args === ModalTriggerStub::responseStartOfDayToSlackWithGitHubIssues($this->workday))
            ->once();

        $this->post(
            route(
                'standups.index',
                ModalTriggerStub::requestStartOfDayFromSlack($this->workday)
            )
        );
    }

    /** @test */
    public function it_updates_a_modal()
    {
        Slack::shouldReceive('updateModal')
            ->withArgs(fn ($args) => $args === AddTaskStub::responseToSlackWithGitHubIssue())
            ->once();

        $this->post(
            route(
                'standups.index',
                AddTaskStub::requestFromSlack($this->workday)
            )
        );
    }

    /** @test */
    public function it_adds_a_task()
    {
        Slack::shouldReceive('updateModal')
            ->withArgs(fn ($args) => Arr::get($args, 'view.blocks.1.block_id') === 'input_with_dispatch_task_1')
            ->once();

        $this->post(
            route(
                'standups.index',
                AddTaskStub::requestFromSlack($this->workday)
            )
        );
    }

    /** @test */
    public function it_adds_edit_button()
    {
        Slack::shouldReceive('updateModal')
            ->withArgs(fn ($args) => Arr::get($args, 'view.blocks.3.block_id') === 'multiple_task_action')
            ->once();

        $this->post(
            route(
                'standups.index',
                AddTaskStub::requestFromSlack($this->workday)
            )
        );
    }

    /** @test */
    public function it_deletes_a_task()
    {
        Slack::shouldReceive('updateModal')
            ->withArgs(fn ($args) => Arr::get($args, 'view.blocks.1.block_id') === 'divider')
            ->once();

        $this->post(
            route(
                'standups.index',
                DeleteTaskStub::requestFromSlackTwoTasks($this->workday)
            )
        );
    }

    /** @test */
    public function it_deletes_a_task_with_more_than_two_tasks()
    {
        Slack::shouldReceive('updateModal')
            ->withArgs(fn ($args) => Arr::get($args, 'view.blocks.5.block_id') === 'github_block_action')
            ->withArgs(fn ($args) => Arr::get($args, 'view.blocks.4.block_id') === 'multiple_task_action')
            ->once();

        $this->post(
            route(
                'standups.index',
                DeleteTaskStub::requestFromSlackTwoOrMoreTasks($this->workday)
            )
        );
    }
}
