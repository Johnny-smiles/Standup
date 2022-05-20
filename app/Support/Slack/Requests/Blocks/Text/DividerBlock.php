<?php

namespace App\Support\Slack\Requests\Blocks\Text;

use App\Support\Slack\Requests\Blocks\Block;
use App\Support\Slack\Requests\Renderable;

class DividerBlock extends Block implements Renderable
{
    public const TYPE = 'divider';

    public function render(): array
    {
        return [
            'type' => self::TYPE,
            'block_id' => 'divider',
        ];
    }
}
