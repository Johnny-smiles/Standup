<?php

namespace App\Support\Slack\Requests\Triggers\Open\Views\OpenActions;

use App\Support\Slack\Requests\Blocks\Actions\GithubIssueSelect;
use App\Support\Slack\Requests\Blocks\Actions\MultipleElementsBlock;

class GithubIssuesInputBlock
{
    public function __invoke($dto, $id): array
    {
        return (new MultipleElementsBlock(
            (new GithubIssueSelect($dto->getGitHubIssues()))->render(),
        ))
            ->setId($id)
            ->render();
    }
}
