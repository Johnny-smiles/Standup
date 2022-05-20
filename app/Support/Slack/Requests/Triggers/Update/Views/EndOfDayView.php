<?php

namespace App\Support\Slack\Requests\Triggers\Update\Views;

use App\Models\Task;
use App\Support\Slack\Requests\SlackDataTransferObject;
use App\Support\Slack\Requests\Triggers\Update\ModalUpdate;
use App\Support\Slack\Requests\Triggers\Update\UpdateActions\EndOfDay\AddTask;
use App\Support\Slack\Requests\Triggers\Update\UpdateActions\EndOfDay\EditTask;
use App\Support\Slack\Requests\Triggers\Update\UpdateActions\EndOfDay\GithubLink;
use App\Support\Slack\Requests\Triggers\Update\UpdateActions\EndOfDay\ModalRefresh;
use App\Support\Slack\Requests\Triggers\ViewBuilderContract;

class EndOfDayView extends ModalUpdate implements ViewBuilderContract
{
    public function buildResponse(SlackDataTransferObject $dto): array
    {
        $this->extractGlobals($dto);

        $this->updateTasksTable();

        return $this->respond(
            match ($this->actionType) {
                'edit_task_button' => (new EditTask)($this->blocks, $dto),
                'add_task_button' => (new AddTask)($this->blocks, $dto),
                'github_oauth_button' => (new GithubLink)($this->blocks, $dto),
                default => (new ModalRefresh)($this->blocks, $this->dto)
            }
        );
    }

    protected function updateTasksTable(): void
    {
        if ($this->actionType === 'github_issues') {
            $this->actionType = 'additional_task';
        }

        switch ($this->actionType) {
            case 'additional_task':
                $this->taskId
                    ? $this->dto->getWorkday()->tasks()->where('id', $this->taskId)
                    ->update(
                        [
                            'user_id' => $this->dto->getUser()->getKey(),
                            'text' => $this->taskValue,
                        ])
                    : $this->dto->getWorkday()->tasks()->create([
                        'user_id' => $this->dto->getUser()->getKey(),
                        'text' => $this->taskValue
                            ?: $this->actionValue,
                    ]);
                break;
            case 'time':
                Task::find($this->taskId)
                    ->update(['time' => $this->actionValue]);
                break;
            case 'status':
                Task::find($this->taskId)
                    ->update(['status' => $this->actionValue]);
                break;
            default:
                break;
        }
    }
}
