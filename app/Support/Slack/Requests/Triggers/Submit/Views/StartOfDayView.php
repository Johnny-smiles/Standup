<?php

namespace App\Support\Slack\Requests\Triggers\Submit\Views;

use App\Support\Slack\Requests\SlackDataTransferObject;
use App\Support\Slack\Requests\Triggers\Submit\ModalSubmit;
use App\Support\Slack\Requests\Triggers\Submit\SubmissionActions\Persist;
use App\Support\Slack\Requests\Triggers\Submit\SubmissionActions\ReturnMessageBuilder;
use App\Support\Slack\Requests\Triggers\ViewBuilderContract;

class StartOfDayView extends ModalSubmit implements ViewBuilderContract
{
    public function buildResponse(SlackDataTransferObject $dto): array
    {
        $this->extractGlobals($dto);

        (new Persist())->handle($dto);

        return $this->respond(
            (new ReturnMessageBuilder())->handle($this->messageText())
        );
    }
}
