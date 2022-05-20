<?php

namespace App\Support\Slack\Requests\Triggers\Open\Views;

use App\Support\Slack\Requests\Blocks\Actions\Buttons\StandupDashboardButton;
use App\Support\Slack\Requests\Blocks\Text\Accessory\ImageElement;
use App\Support\Slack\Requests\Blocks\Text\DividerBlock;
use App\Support\Slack\Requests\Blocks\Text\HeaderBlock;
use App\Support\Slack\Requests\Blocks\Text\MarkdownTextBlockWithAccessory;
use App\Support\Slack\Requests\SlackDataTransferObject;
use App\Support\Slack\Requests\Triggers\Open\ModalOpen;
use App\Support\Slack\Requests\Triggers\ViewBuilderContract;

class WelcomeView extends ModalOpen implements ViewBuilderContract
{
    public function buildResponse(SlackDataTransferObject $dto): array
    {
        $this->extractGlobals($dto);

        $dto->getUser()->teams()->syncWithoutDetaching($dto->getTeam());

        return $this->respond(
            $this->blocks
                ->push((new HeaderBlock())->setText($dto->getUser()->slack_username)->render())
                ->push((new ImageElement())
                    ->setImage(config('services.slack.slack_inspirational'))
                    ->setText('Inspirational')
                    ->render())
                ->push((new DividerBlock())->render())
                ->push((new MarkdownTextBlockWithAccessory())
                    ->setText('Click this button to allow *Standup* to post with your name and avatar.')
                    ->setAccessory((new StandupDashboardButton())->render())
                    ->render())
                ->toArray()
        );
    }
}
