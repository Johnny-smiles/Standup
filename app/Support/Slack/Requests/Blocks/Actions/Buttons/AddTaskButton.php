<?php

namespace App\Support\Slack\Requests\Blocks\Actions\Buttons;

class AddTaskButton
{
    public function render(): array
    {
        return [
            'type' => 'button',
            'action_id' => 'add_task_button',
            'text' => [
                'type' => 'plain_text',
                'text' => 'Add another task',
            ],
        ];
    }
}
