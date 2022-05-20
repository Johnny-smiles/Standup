<?php

namespace App\Support\Slack\Requests\Triggers\Update\UpdateActions\EndOfDay;

use App\Models\Task;
use App\Support\Slack\Requests\Blocks\Actions\ActionsBlock;
use App\Support\Slack\Requests\Blocks\Actions\Buttons\DeleteTaskButton;
use App\Support\Slack\Requests\Blocks\Inputs\InputBlockWithDispatch;
use App\Support\Slack\Requests\SlackDataTransferObject;
use App\Support\Slack\Requests\Triggers\Open\Views\OpenActions\TaskStatusInputBlock;
use App\Support\Slack\Requests\Triggers\Open\Views\OpenActions\TaskSummaryBlock;
use Illuminate\Support\Collection;

class AddTask
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
                (new InputBlockWithDispatch())->setId(0)->render(),
                (new ActionsBlock(
                    (new DeleteTaskButton())->setId(1)->render()
                ))->render()
            );

        return $blocks->toArray();
    }
}
