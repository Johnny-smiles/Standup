<?php

namespace App\Support\Slack\Requests\Triggers\Update\Views;

use App\Support\Slack\Requests\Blocks\Text\Accessory\ImageElement;
use App\Support\Slack\Requests\SlackDataTransferObject;
use App\Support\Slack\Requests\Triggers\Update\ModalUpdate;
use App\Support\Slack\Requests\Triggers\ViewBuilderContract;

class WelcomeView extends ModalUpdate implements ViewBuilderContract
{
    public function buildResponse(SlackDataTransferObject $dto): array
    {
        $this->extractGlobals($dto);

        return $this->respond($this->blocks->replace(
            [
                1 => (new ImageElement())
                    ->setImage(config('services.slack.slack_thumbs_up'))
                    ->setText('ThumbsUp')
                    ->render(),
            ]
        )
            ->toArray()
        );
    }
}
