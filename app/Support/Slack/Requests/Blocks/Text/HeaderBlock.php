<?php

namespace App\Support\Slack\Requests\Blocks\Text;

use App\Support\Slack\Requests\Blocks\Block;
use App\Support\Slack\Requests\Renderable;

class HeaderBlock extends Block implements Renderable
{
    public const TYPE = 'header';

    public function render(): array
    {
        return [
            'type' => self::TYPE,
            'block_id' => 'welcome',
            'text' => [
                'type' => 'plain_text',
                'text' => "Welcome to Standups {$this->text}!",
                'emoji' => true,
            ],
        ];
    }
}
