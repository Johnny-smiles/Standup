<?php

namespace App\Support\Slack\Requests\Blocks\Actions;

use App\Support\Slack\Requests\Blocks\Block;
use App\Support\Slack\Requests\Renderable;
use Illuminate\Support\Collection;

class GithubIssueSelect extends Block implements Renderable
{
    private Collection $options;

    public function __construct(array $issues)
    {
        $this->options = Collection::empty();

        collect($issues)->each(function ($issue) {
            $this->options
                ->push([
                    'text' => [
                        'type' => 'plain_text',
                        'text' => substr($issue['repository']['name'], 0, 25).'  # '.substr($issue['number'], 0, 5).'  '.substr($issue['title'], 0, 40),
                    ],
                    'value' => substr($issue['title'], 0, 40),
                ]);
        });
    }

    public function render(): array
    {
        return [
            'type' => 'static_select',
            'placeholder' => [
                'type' => 'plain_text',
                'text' => 'Assigned GitHub Issues',
            ],
            'action_id' => 'github_issues',
            'options' => $this->options->toArray(),
        ];
    }
}
