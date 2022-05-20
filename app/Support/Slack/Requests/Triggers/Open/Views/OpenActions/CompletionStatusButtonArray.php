<?php

namespace App\Support\Slack\Requests\Triggers\Open\Views\OpenActions;

use App\Support\Slack\Requests\Blocks\Actions\Buttons\BlockedTaskButton;
use App\Support\Slack\Requests\Blocks\Actions\Buttons\CompletedTaskButton;
use App\Support\Slack\Requests\Blocks\Actions\Buttons\DeleteTaskButton;
use App\Support\Slack\Requests\Blocks\Actions\Buttons\InProgressTaskButton;
use App\Support\Slack\Requests\Blocks\Actions\MultipleElementsBlock;

class CompletionStatusButtonArray
{
    public function __invoke(int $taskId, ?string $status, ?string $time): array
    {
        return (new MultipleElementsBlock(
            (new BlockedTaskButton())->setId($taskId)->render(),
            (new CompletedTaskButton())->setId($taskId)->render(),
            (new DeleteTaskButton())->setId($taskId)->render(),
            (new InProgressTaskButton())->setId($taskId)->render(),
        ))
            ->setId($taskId)
            ->render();
    }
}
