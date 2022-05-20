<?php

namespace App\Support\Slack\Requests\Blocks\Inputs;

use App\Support\Slack\Requests\Blocks\Block;
use App\Support\Slack\Requests\Renderable;

class InputBlock extends Block implements Renderable
{
    public const TYPE = 'input';

    public function render(): array
    {
        return [
            'type' => self::TYPE,
            'block_id' => "block_task_{$this->id}",
            'label' => [
                'type' => 'plain_text',
                'text' => 'Task:',
                'emoji' => true,
            ],
            'element' => [
                'type' => 'plain_text_input',
                'action_id' => "action_task_{$this->id}",
            ],
        ];
    }
}
