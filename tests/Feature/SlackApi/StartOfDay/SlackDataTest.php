<?php

namespace Tests\Feature\StartOfDay;

use App\Models\Workday;
use App\Support\GitHub\Blueprints\Stubs\GithubResponse;
use App\Support\GitHub\Services\GitHub;
use App\Support\Slack\Blueprints\Stubs\StartOfDay\AddTaskStub;
use App\Support\Slack\Blueprints\Stubs\StartOfDay\DeleteTaskStub;
use App\Support\Slack\Blueprints\Stubs\StartOfDay\EditTaskStub;
use App\Support\Slack\Blueprints\Stubs\StartOfDay\LinkGitHub;
use App\Support\Slack\Blueprints\Stubs\StartOfDay\ModalTriggerStub;
use App\Support\Slack\Blueprints\Stubs\StartOfDay\SubmissionStub;
use App\Support\Slack\Services\Slack;
use Illuminate\Support\Arr;
use Tests\TestCase;

class SlackDataTest extends TestCase
{
    protected Workday $workday;

    protected function setUp(): void
    {
        parent::setUp();

        $this->workday = Workday::factory()->statusCompleted()->create();
    }

    /** @test */
    public function it_opens_a_modal()
    {
        Slack::shouldReceive('openModal')
            ->withArgs(fn ($args) => $args === ModalTriggerStub::responseStartOfDayToSlack($this->workday))
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
            ->withArgs(fn ($args) => $args === AddTaskStub::responseToSlack())
            ->once();

        $this->post(
            route(
                'standups.index',
                AddTaskStub::requestFromSlack($this->workday)
            )
        );
    }

    /** @test */
    public function it_renders_a_response_message()
    {
        Slack::shouldReceive('postMessage')
            ->withArgs(fn ($args) => $args === SubmissionStub::messageStructureResponse($this->workday))
            ->once();

        $this->post(
            route(
                'standups.index',
                SubmissionStub::requestFromSlack($this->workday)
            )
        );
    }

    /** @test */
    public function it_adds_a_task()
    {
        Slack::shouldReceive('updateModal')
            ->withArgs(fn ($args) => count($args['view']['blocks']) === 5)
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
    public function it_adds_delete_button()
    {
        Slack::shouldReceive('updateModal')
            ->withArgs(fn ($args) => Arr::get($args, 'view.blocks.1.block_id') === 'remove_block_task_1')
            ->once();

        $this->post(
            route(
                'standups.index',
                EditTaskStub::requestFromSlack($this->workday)
            )
        );
    }

    /** @test */
    public function it_deletes_a_task()
    {
        Slack::shouldReceive('updateModal')
            ->withArgs(fn ($args) => count($args['view']['blocks']) === 4)
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
            ->withArgs(fn ($args) => count($args['view']['blocks']) === 5)
            ->once();

        $this->post(
            route(
                'standups.index',
                DeleteTaskStub::requestFromSlackTwoOrMoreTasks($this->workday)
            )
        );
    }

    /** @test */
    public function it_stores_task_text()
    {
        Slack::shouldReceive('postMessage')->once();

        $this->post(
            route(
                'standups.index',
                SubmissionStub::requestFromSlack($this->workday)
            )
        );

        $this->assertDatabaseHas('tasks', [
            'text' => [
                'Hello world',
                'Its a beautiful day',
                'Lets explore',
            ],
        ]);
    }

    /** @test */
    public function it_links_github()
    {
        $this->workday->user->update([
            'github_token' => 'XOXO',
        ]);

        GitHub::shouldReceive('githubIssuesQuery')
            ->once()
            ->andReturns(json_encode(GithubResponse::responseFromGitHubIssuesQuery()));

        Slack::shouldReceive('updateModal')
            ->withArgs(fn ($args) => Arr::get($args, 'view.blocks.4.text.text') === 'GitHub linked!')
            ->once();

        $this->post(
            route(
                'standups.index',
                LinkGitHub::requestFromSlack($this->workday)
            )
        );
    }

    /** @test */
    public function it_links_tells_user_to_login_to_standup_to_link()
    {
        Slack::shouldReceive('updateModal')
            ->withArgs(fn ($args) => Arr::get($args, 'view.blocks.4.text.text') === 'Log Into Standup Dashboard to Link GitHub!')
            ->once();

        $this->post(
            route(
                'standups.index',
                LinkGitHub::requestFromSlack($this->workday)
            )
        );
    }
}
