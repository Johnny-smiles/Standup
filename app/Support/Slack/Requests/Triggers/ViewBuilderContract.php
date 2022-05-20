<?php

namespace App\Support\Slack\Requests\Triggers;

use App\Support\Slack\Requests\SlackDataTransferObject;

interface ViewBuilderContract
{
    public function buildResponse(SlackDataTransferObject $dto);
}
