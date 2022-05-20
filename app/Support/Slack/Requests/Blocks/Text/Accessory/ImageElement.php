<?php

namespace App\Support\Slack\Requests\Blocks\Text\Accessory;

use App\Support\Slack\Requests\Blocks\Block;
use App\Support\Slack\Requests\Renderable;

class ImageElement extends Block implements Renderable
{
    public const TYPE = 'image';

    public function render(): array
    {
        return [
            'type' => 'image',
            'image_url' => $this->image,
            'alt_text' => $this->text,
        ];
    }
}
