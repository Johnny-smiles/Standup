<?php

namespace App\Support\Slack\Requests\Triggers\Submit;

use App\Support\Slack\Requests\Blocks\Text\EphemeralMessageBlock;
use App\Support\Slack\Requests\Blocks\Text\MessageBlock;
use App\Support\Slack\Requests\Exceptions\MissingTriggerIdException;
use App\Support\Slack\Requests\SlackDataTransferObject;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

abstract class ModalSubmit
{
    protected SlackDataTransferObject $dto;
    protected Collection $blocks;
    protected string $givenName;
    protected string $submissionId;

    protected function extractGlobals(SlackDataTransferObject $dto): void
    {
        $this->runGuards($dto->getRequest());

        $this->dto = $dto;

        $dto->setTaskText();

        $this->blocks = Collection::empty();
    }

    protected function respond(array $blocks): array
    {
        return (Arr::get($this->dto->getRequest(), 'view.submit.text') === 'Create first Workday')
            ? (new EphemeralMessageBlock())->render($blocks, $this->dto->getTeam()->channel->slack_channel_id, $this->dto->getUser()->slack_id)
            : (new MessageBlock())->render($blocks, $this->dto->getTeam()->channel->slack_channel_id, $this->dto->getUser());
    }

    protected function getTaskText($values): Collection
    {
        return str_contains(array_key_first($values), 'block_task')
            ? collect($values)->values()->map(function ($task) {
                return (collect($task)->values()->toArray())[0]['value'];
            })
            : Collection::empty();
    }

    protected function getName(): string
    {
        return $this->dto->getUser()->name ?? $this->dto->getUser()->slack_username;
    }

    protected function messageText(): string
    {
        $taskCollection = Collection::empty();

        $this->dto->getUser()->workdays()->latest('id')->first()->tasks
            ->reject(function ($task) {
                return in_array('deleted', $task->toArray());
            })
            ->each(function ($task) use ($taskCollection) {
                $task->status
                    ? match ($task->status) {
                        'completed' => $taskCollection->push('• '.$task->text.' ✅'),
                    'in_progress' => $taskCollection->push('• '.$task->text.' 🚧'),
                    'blocked' => $taskCollection->push('• '.$task->text.' ❌'),
                    }
                : $taskCollection->push('• '.$task->text);
            });

        $taskCollection
            ->prepend(['Today:'])
            ->flatten()
            ->reduce(
                function ($message, $task) {
                    return $message->push($message->last().$task."\n");
                },
                $taskMessage = collect([])
            );

        return $taskMessage->last();
    }

    /**
     * @throws MissingTriggerIdException
     */
    private function runGuards(array $request): void
    {
        if (! array_key_exists('trigger_id', $request)) {
            throw new MissingTriggerIdException();
        }
    }
}
