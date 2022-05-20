<?php

namespace App\Support\Slack\Requests\Triggers\Update\UpdateActions\EndOfDay;

use App\Models\Task;
use App\Support\Slack\Requests\Blocks\Actions\ActionsBlock;
use App\Support\Slack\Requests\Blocks\Actions\Buttons\AddTaskButton;
use App\Support\Slack\Requests\Blocks\Actions\Buttons\CancelActionButton;
use App\Support\Slack\Requests\Blocks\Inputs\InputBlockWithDispatch;
use App\Support\Slack\Requests\SlackDataTransferObject;
use Illuminate\Support\Collection;

class EditTask
{
    public function __invoke(Collection $blocks, SlackDataTransferObject $dto): array
    {
        $dto->getWorkday()->fresh()
            ->tasks()
            ->each(function (Task $task) use (&$blocks) {
                $blocks->push(
                    (new InputBlockWithDispatch())
                        ->setId($task->getKey())
                        ->setInitialValue($task->text)
                        ->render()
                );
            });

        $blocks
            ->push(
                (new ActionsBlock(
                    (new AddTaskButton())->render(),
                    (new CancelActionButton())->render()
                ))->render()
            );

        return $blocks->toArray();
    }
}
