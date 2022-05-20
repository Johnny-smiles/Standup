<?php

namespace App\Support\Slack\Requests\Blocks\Text;

use App\Support\Slack\Requests\Blocks\Block;
use App\Support\Slack\Requests\Renderable;

class PlainTextBlock extends Block implements Renderable
{
    public const TYPE = 'section';

    public function render(): array
    {
        return [
            'type' => self::TYPE,
            'block_id' => 'plain_text_block',
            'text' => [
                'type' => 'plain_text',
                'text' => $this->text,
                'emoji' => true,
            ],
        ];
    }
}
