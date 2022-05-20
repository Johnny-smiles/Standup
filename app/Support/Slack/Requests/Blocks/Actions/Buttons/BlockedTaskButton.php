<?php

namespace App\Support\Slack\Requests\Blocks\Actions\Buttons;

use App\Support\Slack\Requests\Blocks\Block;
use App\Support\Slack\Requests\Renderable;

class BlockedTaskButton extends Block implements Renderable
{
    public function render(): array
    {
        return [
            'type' => 'button',
            'action_id' => 'blocked',
            'value' => "{$this->id}",
            'text' => [
                'type' => 'plain_text',
                'text' => 'Blocked',
            ],
        ];
    }
}
