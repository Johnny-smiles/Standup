<?php

namespace App\Support\Slack\Requests\Triggers\Open\Views;

use App\Support\Slack\Requests\Blocks\Actions\ActionsBlock;
use App\Support\Slack\Requests\Blocks\Actions\Buttons\AddTaskButton;
use App\Support\Slack\Requests\Blocks\Actions\Buttons\GitHubOauthButton;
use App\Support\Slack\Requests\Blocks\Actions\Buttons\StandupDashboardButton;
use App\Support\Slack\Requests\Blocks\Actions\GithubBlock;
use App\Support\Slack\Requests\Blocks\Actions\GithubIssueSelect;
use App\Support\Slack\Requests\Blocks\Inputs\InputBlockWithDispatch;
use App\Support\Slack\Requests\SlackDataTransferObject;
use App\Support\Slack\Requests\Triggers\Open\ModalOpen;
use App\Support\Slack\Requests\Triggers\ViewBuilderContract;

class StartOfDayView extends ModalOpen implements ViewBuilderContract
{
    public function buildResponse(SlackDataTransferObject $dto): array
    {
        $this->extractGlobals($dto);

        $this->blocks
            ->push((new InputBlockWithDispatch())->setId(1)->render())
            ->push(
                (new ActionsBlock(
                    (new AddTaskButton())->render()
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
