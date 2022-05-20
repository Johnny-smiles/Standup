<?php

namespace App\Support\Slack\Requests\Triggers\Update\UpdateActions\EndOfDay;

use App\Models\Task;
use App\Support\GitHub\Services\GitHub;
use App\Support\Slack\Requests\Blocks\Actions\Buttons\GitHubOauthButton;
use App\Support\Slack\Requests\Blocks\Actions\Buttons\StandupDashboardButton;
use App\Support\Slack\Requests\Blocks\Actions\GithubBlock;
use App\Support\Slack\Requests\Blocks\Actions\GithubIssueSelect;
use App\Support\Slack\Requests\Blocks\Text\PlainTextBlock;
use App\Support\Slack\Requests\SlackDataTransferObject;
use App\Support\Slack\Requests\Triggers\Open\Views\OpenActions\TaskStatusInputBlock;
use App\Support\Slack\Requests\Triggers\Open\Views\OpenActions\TaskSummaryBlock;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class GithubLink
{
    public function __invoke(Collection $blocks, SlackDataTransferObject $dto): array
    {
        $dto->getWorkday()->fresh()
            ->tasks()
            ->each(function (Task $task) use (&$blocks) {
                $blocks
                    ->push((new TaskSummaryBlock())->build($task))
                    ->push((new TaskStatusInputBlock())($task));
            });

        sleep(3);

        $dto->setAndUpdateUser();

        if ($dto->getUser()->github_token) {
            $this->cacheGitHubIssues($dto);

            $blocks
                ->push(
                    (new PlainTextBlock())
                        ->setText('GitHub linked!')
                        ->render()
                )
                ->push(
                    (new GithubBlock(
                        (new GithubIssueSelect($dto->getGitHubIssues()))->render(),
                        (new StandupDashboardButton())->render()
                    ))->render()
                );
        } else {
            $blocks
                ->push(
                    (new PlainTextBlock())
                        ->setText('Log Into Standup Dashboard to Link GitHub!')
                        ->render()
                )
                ->push(
                    (new GithubBlock(
                        (new GitHubOauthButton())->render(),
                        (new StandupDashboardButton())->render()
                    ))->render()
                );
        }

        return $blocks->toArray();
    }

    protected function cacheGitHubIssues(SlackDataTransferObject $dto)
    {
        $issues = json_decode(
            GitHub::githubIssuesQuery(
                [
                    'number_of_issues' => 5,
                    'state' => 'OPEN',
                ],
                $dto->getUser()->github_token
            ),
            true
        )
        ['data']['viewer']['issues']['nodes'];

        Cache::put($dto->getUser()->getKey().'.github-issues', $issues);
    }
}
