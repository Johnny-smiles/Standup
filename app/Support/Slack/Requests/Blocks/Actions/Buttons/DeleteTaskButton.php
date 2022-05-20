<?php

namespace App\Support\Slack\Requests\Blocks\Actions\Buttons;

use App\Support\Slack\Requests\Blocks\Block;
use App\Support\Slack\Requests\Renderable;

class DeleteTaskButton extends Block implements Renderable
{
    public function render(): array
    {
        return [
            'type' => 'button',
            'action_id' => 'delete',
            'value' => "{$this->id}",
            'text' => [
                'type' => 'plain_text',
                'text' => 'Delete',
            ],
        ];
    }
}
