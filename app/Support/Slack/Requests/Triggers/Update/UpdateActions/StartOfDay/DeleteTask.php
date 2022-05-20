<?php

namespace App\Support\Slack\Requests\Triggers\Update\UpdateActions\StartOfDay;

use App\Support\Slack\Requests\Blocks\Actions\ActionsBlock;
use App\Support\Slack\Requests\Blocks\Actions\Buttons\AddTaskButton;
use App\Support\Slack\Requests\Blocks\Actions\Buttons\EditTaskButton;
use App\Support\Slack\Requests\Blocks\Actions\Buttons\GitHubOauthButton;
use App\Support\Slack\Requests\Blocks\Actions\Buttons\StandupDashboardButton;
use App\Support\Slack\Requests\Blocks\Actions\GithubBlock;
use App\Support\Slack\Requests\Blocks\Actions\GithubIssueSelect;
use App\Support\Slack\Requests\Blocks\Text\DividerBlock;
use App\Support\Slack\Requests\SlackDataTransferObject;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class DeleteTask
{
    public function __invoke(Collection $blocks, SlackDataTransferObject $dto): array
    {
        $filtered = $blocks->reject(function (array $block) use ($dto) {
            return in_array($block['block_id'],
                [
                    Str::startsWith($block['block_id'],
                        'remove_block_task_'),
                    Arr::get($dto->getRequest()['actions'][0], 'value'),
                    'single_task_action',
                ]
            );
        });

        $filtered->push((new DividerBlock())->render());

        $filtered->count() === 1
            ? $filtered
                ->push(
                    (new ActionsBlock(
                        (new AddTaskButton())->render()
                    ))->render()
                )
            : $filtered
                ->push(
                    (new ActionsBlock(
                        (new AddTaskButton())->render(),
                        (new EditTaskButton())->render()
                    ))->render()
                );

        $filtered
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
