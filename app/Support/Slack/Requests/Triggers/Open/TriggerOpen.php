<?php

namespace App\Support\Slack\Requests\Triggers\Open;

use App\Support\Slack\Requests\SlackDataTransferObject;
use App\Support\Slack\Requests\Triggers\Open\Views\EndOfDayView;
use App\Support\Slack\Requests\Triggers\Open\Views\StartOfDayView;
use App\Support\Slack\Requests\Triggers\Open\Views\WelcomeView;
use App\Support\Slack\Services\Slack;

class TriggerOpen
{
    public function __construct(public SlackDataTransferObject $dto)
    {
    }

    public function handleSlackRequest(): void
    {
        $view = EndOfDayView::class;

        if (! $this->dto->getWorkday()) {
            $view = WelcomeView::class;
        } elseif ($this->dto->getWorkday()->completed) {
            $view = StartOfDayView::class;
        }

        $this->openModal($view);
    }

    private function openModal(string $view): void
    {
        Slack::openModal(
            app($view)->buildResponse($this->dto),
            $this->dto->getBotToken()
        );
    }
}
