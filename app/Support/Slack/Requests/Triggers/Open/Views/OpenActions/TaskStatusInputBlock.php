<?php

namespace App\Support\Slack\Requests\Triggers\Open\Views\OpenActions;

use App\Models\Task;
use App\Support\Slack\Requests\Blocks\Actions\MultipleElementsBlock;
use App\Support\Slack\Requests\Blocks\Actions\StatusSelect;
use App\Support\Slack\Requests\Blocks\Actions\TimeSelect;

class TaskStatusInputBlock
{
    public function __invoke(Task $task): array
    {
        return (new MultipleElementsBlock(
            (new TimeSelect())->setTime($task->time)->render(),
            (new StatusSelect())->setStatus($task->status)->render(),
        ))
            ->setId($task->getKey())
            ->render();
    }
}
