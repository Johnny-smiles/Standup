<?php

namespace App\Support\Slack\Requests\Triggers\Update\Views;

use App\Support\Slack\Requests\SlackDataTransferObject;
use App\Support\Slack\Requests\Triggers\Update\ModalUpdate;
use App\Support\Slack\Requests\Triggers\Update\UpdateActions\StartOfDay\AddTask;
use App\Support\Slack\Requests\Triggers\Update\UpdateActions\StartOfDay\DeleteTask;
use App\Support\Slack\Requests\Triggers\Update\UpdateActions\StartOfDay\EditTask;
use App\Support\Slack\Requests\Triggers\Update\UpdateActions\StartOfDay\GitHubLink;
use App\Support\Slack\Requests\Triggers\ViewBuilderContract;

class StartOfDayView extends ModalUpdate implements ViewBuilderContract
{
    /**
     * @throws \Exception
     */
    public function buildResponse(SlackDataTransferObject $dto): array
    {
        $this->extractGlobals($dto);

        if (in_array($this->actionType, ['add_task_button', 'github_issues'])) {
            $this->actionType = 'additional_task';
        }

        if (in_array($this->actionType, ['cancel_action_button', 'standup_url'])) {
            $this->actionType = 'remove_task_button';
        }

        return $this->respond(
            match ($this->actionType) {
                'additional_task' => (new AddTask)($this->blocks, $this->taskCount, $this->dto, $this->actionValue),
                'edit_task_button' => (new EditTask)($this->blocks),
                'remove_task_button' => (new DeleteTask)($this->blocks, $dto),
                'github_oauth_button' => (new GitHubLink())($this->blocks, $dto),
                default => throw new \Exception('Invalid action type '.$this->actionType)
            }
        );
    }
}
