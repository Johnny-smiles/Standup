<?php

namespace App\Support\Slack\Requests\Triggers\Update\UpdateActions\StartOfDay;

use App\Support\GitHub\Services\GitHub;
use App\Support\Slack\Requests\Blocks\Actions\Buttons\GitHubOauthButton;
use App\Support\Slack\Requests\Blocks\Actions\Buttons\StandupDashboardButton;
use App\Support\Slack\Requests\Blocks\Actions\GithubBlock;
use App\Support\Slack\Requests\Blocks\Actions\GithubIssueSelect;
use App\Support\Slack\Requests\Blocks\Text\PlainTextBlock;
use App\Support\Slack\Requests\SlackDataTransferObject;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class GitHubLink
{
    public function __invoke(Collection $blocks, SlackDataTransferObject $dto): array
    {
        $filtered = $blocks->reject(function (array $block) {
            return $block['block_id'] === 'github_block_action';
        });

        sleep(3);

        $dto->setAndUpdateUser();

        if ($dto->getUser()->github_token) {
            $this->cacheGitHubIssues($dto);

            $filtered
                ->push(
                    (new PlainTextBlock())
                        ->setText('GitHub linked!')
                        ->render()
                )
                ->push(
                    (new GithubBlock(
                        (new GithubIssueSelect($dto->getGitHubIssues()))->render(),
                        (new StandupDashboardButton())->render()
                    ))->render()
                );
        } else {
            $filtered
                ->push(
                    (new PlainTextBlock())
                        ->setText('Log Into Standup Dashboard to Link GitHub!')
                        ->render()
                )
                ->push(
                    (new GithubBlock(
                        (new GitHubOauthButton())->render(),
                        (new StandupDashboardButton())->render()
                    ))->render()
                );
        }

        return $filtered->toArray();
    }

    protected function cacheGitHubIssues(SlackDataTransferObject $dto)
    {
        $issues = json_decode(
            GitHub::githubIssuesQuery(
                [
                    'number_of_issues' => 5,
                    'state' => 'OPEN',
                ],
                $dto->getUser()->github_token
            ),
            true
        )
        ['data']['viewer']['issues']['nodes'];

        Cache::put($dto->getUser()->getKey().'.github-issues', $issues);
    }
}
