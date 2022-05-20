<?php

namespace App\Support\Slack\Requests\Blocks\Inputs;

use App\Support\Slack\Requests\Blocks\Block;
use App\Support\Slack\Requests\Renderable;

class InputBlockWithDispatch extends Block implements Renderable
{
    public const TYPE = 'input';

    public function render(): array
    {
        return [
            'dispatch_action' => true,
            'type' => self::TYPE,
            'block_id' => $this->id
                ? "input_with_dispatch_task_{$this->id}"
                : 'newTask',
            'element' => [
                'type' => 'plain_text_input',
                'action_id' => 'additional_task',
                'initial_value' => $this->initialValue
                    ?: '',
                'placeholder' => [
                    'type' => 'plain_text',
                    'text' => $this->placeholder
                        ?: 'Write something',
                ],
            ],
            'label' => [
                'type' => 'plain_text',
                'text' => 'Task:',
                'emoji' => true,
            ],
        ];
    }
}
