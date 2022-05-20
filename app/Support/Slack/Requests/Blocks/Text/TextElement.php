<?php

namespace App\Support\Slack\Requests\Blocks\Text;

use App\Support\Slack\Requests\Blocks\Block;
use App\Support\Slack\Requests\Renderable;

class TextElement extends Block implements Renderable
{
    public const TYPE = 'mrkdwn';

    public function render(): array
    {
        return [
            'type' => self::TYPE,
            'text' => $this->text,
        ];
    }
}
