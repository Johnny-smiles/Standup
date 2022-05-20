<?php

namespace App\Support\Slack\Requests\Blocks\Actions\Buttons;

class EditTaskButton
{
    public function render(): array
    {
        return [
            'type' => 'button',
            'action_id' => 'edit_task_button',
            'value' => 'edit_task_button',
            'text' => [
                'type' => 'plain_text',
                'text' => 'Edit a task',
            ],
        ];
    }
}
