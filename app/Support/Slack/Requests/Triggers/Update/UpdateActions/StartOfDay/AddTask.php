<?php

namespace App\Support\Slack\Requests\Triggers\Update\UpdateActions\StartOfDay;

use App\Support\Slack\Requests\Blocks\Actions\ActionsBlock;
use App\Support\Slack\Requests\Blocks\Actions\Buttons\AddTaskButton;
use App\Support\Slack\Requests\Blocks\Actions\Buttons\EditTaskButton;
use App\Support\Slack\Requests\Blocks\Actions\Buttons\GitHubOauthButton;
use App\Support\Slack\Requests\Blocks\Actions\Buttons\StandupDashboardButton;
use App\Support\Slack\Requests\Blocks\Actions\GithubBlock;
use App\Support\Slack\Requests\Blocks\Actions\GithubIssueSelect;
use App\Support\Slack\Requests\Blocks\Inputs\InputBlockWithDispatch;
use App\Support\Slack\Requests\Blocks\Text\DividerBlock;
use App\Support\Slack\Requests\SlackDataTransferObject;
use Illuminate\Support\Collection;

class AddTask
{
    public function __invoke(Collection $blocks, int $taskCount, SlackDataTransferObject $dto, ?string $taskValue): array
    {
        $filtered = $blocks->reject(function (array $block) {
            return in_array($block['block_id'], ['single_task_action', 'multiple_task_action', 'github_select', 'github_block_action', 'divider', 'plain_text_block']);
        });

        $filtered->push(
            (new InputBlockWithDispatch())
                ->setId($taskCount + 1)
                ->setInitialValue($taskValue)
                ->render())
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

        return $filtered->toArray();
    }
}
