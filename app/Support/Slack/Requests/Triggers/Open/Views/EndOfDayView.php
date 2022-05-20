<?php

namespace App\Support\Slack\Requests\Triggers\Open\Views;

use App\Models\Task;
use App\Support\Slack\Requests\Blocks\Actions\ActionsBlock;
use App\Support\Slack\Requests\Blocks\Actions\Buttons\AddTaskButton;
use App\Support\Slack\Requests\Blocks\Actions\Buttons\EditTaskButton;
use App\Support\Slack\Requests\Blocks\Actions\Buttons\GitHubOauthButton;
use App\Support\Slack\Requests\Blocks\Actions\Buttons\StandupDashboardButton;
use App\Support\Slack\Requests\Blocks\Actions\GithubBlock;
use App\Support\Slack\Requests\Blocks\Actions\GithubIssueSelect;
use App\Support\Slack\Requests\Blocks\Text\DividerBlock;
use App\Support\Slack\Requests\SlackDataTransferObject;
use App\Support\Slack\Requests\Triggers\Open\ModalOpen;
use App\Support\Slack\Requests\Triggers\Open\Views\OpenActions\TaskStatusInputBlock;
use App\Support\Slack\Requests\Triggers\Open\Views\OpenActions\TaskSummaryBlock;
use App\Support\Slack\Requests\Triggers\ViewBuilderContract;

class EndOfDayView extends ModalOpen implements ViewBuilderContract
{
    public function buildResponse(SlackDataTransferObject $dto): array
    {
        $this->extractGlobals($dto);

        $dto->getWorkday()
            ->tasks()
            ->each(function (Task $task) {
                $this->blocks
                    ->push((new TaskSummaryBlock())->build($task))
                    ->push((new TaskStatusInputBlock())($task));
            });

        $this->blocks
            ->push((new DividerBlock())->render())
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

        return $this->respond($this->blocks->toArray());
    }
}
