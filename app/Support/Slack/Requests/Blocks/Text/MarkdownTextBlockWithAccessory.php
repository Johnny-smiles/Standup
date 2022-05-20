<?php

namespace App\Support\Slack\Requests\Blocks\Text;

use App\Support\Slack\Requests\Blocks\Block;
use App\Support\Slack\Requests\Renderable;

class MarkdownTextBlockWithAccessory extends Block implements Renderable
{
    public const TYPE = 'section';

    public function render(): array
    {
        return [
            'type' => self::TYPE,
            'block_id' => "{$this->id}",
            'text' => [
                'type' => 'mrkdwn',
                'text' => $this->text,
            ],
            'accessory'=> $this->accessory,
        ];
    }
}
