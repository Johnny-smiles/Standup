<?php

namespace App\Support\Slack\Requests\Triggers\Submit\SubmissionActions;

use App\Support\Slack\Requests\SlackDataTransferObject;

class Persist
{
    public function handle(SlackDataTransferObject $dto): void
    {
        $workday = $dto->getUser()->workdays()->create([
            'submission_id' => $dto->getRequest()['trigger_id'],
            'channel_id' => $dto->getTeam()->channel->getkey(),
        ]);

        $dto->getTaskText()->each(function (string $task) use ($workday, $dto) {
            $dto->getUser()->tasks()->create([
                'workday_id' => $workday->getKey(),
                'text' => $task,
            ]);
        });
    }
}
