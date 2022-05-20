<?php

namespace App\Support\Slack\Requests\Blocks\Actions;

use App\Support\Slack\Requests\Blocks\Block;
use App\Support\Slack\Requests\Renderable;

class MultipleElementsBlock extends Block implements Renderable
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
            'block_id' => "elements_{$this->id}",
            'elements' => $this->elements,
        ];
    }
}
