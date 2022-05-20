<?php

namespace App\Support\Slack\Requests\Triggers\Update\UpdateActions\EndOfDay;

use App\Models\Task;
use App\Support\Slack\Requests\Blocks\Actions\ActionsBlock;
use App\Support\Slack\Requests\Blocks\Actions\Buttons\AddTaskButton;
use App\Support\Slack\Requests\Blocks\Actions\Buttons\EditTaskButton;
use App\Support\Slack\Requests\Blocks\Actions\Buttons\GitHubOauthButton;
use App\Support\Slack\Requests\Blocks\Actions\Buttons\StandupDashboardButton;
use App\Support\Slack\Requests\Blocks\Actions\GithubBlock;
use App\Support\Slack\Requests\Blocks\Actions\GithubIssueSelect;
use App\Support\Slack\Requests\SlackDataTransferObject;
use App\Support\Slack\Requests\Triggers\Open\Views\OpenActions\TaskStatusInputBlock;
use App\Support\Slack\Requests\Triggers\Open\Views\OpenActions\TaskSummaryBlock;
use Illuminate\Support\Collection;

class ModalRefresh
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

        $blocks
            ->push(
                (new ActionsBlock(
                    (new AddTaskButton())->render(),
                    (new EditTaskButton())->render()
                ))->render()
            )
            ->push(
                (new GithubBlock(
                    ($dto->getGitHubIssues()
                        ? (new GithubIssueSelect($dto->getGitHubIssues()))->render()
                        : (new GitHubOauthButton())->render()),
                    (new StandupDashboardButton())->render()
                ))->render()
            );

        return $blocks->toArray();
    }
}
