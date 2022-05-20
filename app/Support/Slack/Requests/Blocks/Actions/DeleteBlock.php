<?php

namespace App\Support\Slack\Requests\Blocks\Actions;

use App\Support\Slack\Requests\Blocks\Block;
use App\Support\Slack\Requests\Renderable;

class DeleteBlock extends Block implements Renderable
{
    public const TYPE = 'actions';

    public function render(): array
    {
        return [
            'type' => self::TYPE,
            'block_id' => "remove_block_task_{$this->id}",
            'elements' => [
                [
                    'type' => 'button',
                    'style' => 'danger',
                    'action_id' => 'remove_task_button',
                    'value' => "input_with_dispatch_task_{$this->id}",
                    'text' => [
                        'type' => 'plain_text',
                        'text' => 'Delete task.',
                    ],
                ],
            ],
        ];
    }
}
