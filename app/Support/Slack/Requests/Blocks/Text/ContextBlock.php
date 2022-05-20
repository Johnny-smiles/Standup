<?php

namespace App\Support\Slack\Requests\Blocks\Text;

use App\Support\Slack\Requests\Blocks\Block;
use App\Support\Slack\Requests\Renderable;

class ContextBlock extends Block implements Renderable
{
    public const TYPE = 'context';

    private array $elements;

    public function __construct($elements)
    {
        $this->elements = $elements;
    }

    public function render(): array
    {
        return [
            'type' => self::TYPE,
            'block_id' => "task_{$this->id}",
            'elements' => $this->elements,
        ];
    }
}
