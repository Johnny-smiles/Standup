<?php

namespace App\Support\Slack\Requests\Blocks\Actions;

use App\Support\Slack\Requests\Renderable;

class ActionsBlock implements Renderable
{
    public const TYPE = 'actions';

    private array $elements;

    public function __construct(...$elements)
    {
        $this->elements = $elements;
    }

    public function render(): array
    {
        return [
            'type' => self::TYPE,
            'block_id' => count($this->elements) === 1
                ? 'single_task_action'
                : 'multiple_task_action',
            'elements' => $this->elements,
        ];
    }
}
