<?php

namespace App\Support\GitHub\Blueprints\Stubs;

class GithubResponse
{
    public static function responseFromGitHubIssuesQuery(): array
    {
        return [
            'data' => [
                'viewer' => [
                    'issues' => [
                        'nodes' => [
                            0 => [
                                'repository' => [
                                    'name' => 'PracticeRepo',
                                ],
                                'title' => 'Practice issue',
                                'number' => 1,
                            ],
                            1 => [
                                'repository' => [
                                    'name' => 'PracticeRepo',
                                ],
                                'title' => 'Issue number 2',
                                'number' => 2,
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    public static function responseFromGitHubRedirect(): array
    {
        return [
            'access_token=gho_RandomToken1234&scope=read%3Auser&token_type=bearer ',
        ];
    }

    public static function parsedToken(): array
    {
        return [
            'access_token' => 'gho_RandomToken1234',
            'scope' => 'read:user',
            'token_type' => 'bearer',
        ];
    }

    public static function gitHubUserResponse(): array
    {
        return [
            'login' => 'Johnny-Doe',
            'id' => 70185533,
            'node_id' => 'NODE_ID',
            'avatar_url' => 'https://avatars.githubusercontent.com/',
            'gravatar_id' => '',
            'url' => 'https://api.github.com/users/Johnny-Doe',
            'html_url' => 'https://github.com/Johnny-Doe',
            'followers_url' => 'https://api.github.com/users/Johnny-Doe/followers',
            'following_url' => 'https://api.github.com/users/Johnny-Doe/following{/other_user}',
            'gists_url' => 'https://api.github.com/users/Johnny-Doe/gists{/gist_id}',
            'starred_url' => 'https://api.github.com/users/Johnny-Doe/starred{/owner}{/repo}',
            'subscriptions_url' => 'https://api.github.com/users/Johnny-Doe/subscriptions',
            'organizations_url' => 'https://api.github.com/users/Johnny-Doe/orgs',
            'repos_url' => 'https://api.github.com/users/Johnny-Doe/repos',
            'events_url' => 'https://api.github.com/users/Johnny-Doe/events{/privacy}',
            'received_events_url' => 'https://api.github.com/users/Johnny-Doe/received_events',
            'type' => 'User',
            'site_admin' => false,
            'name' => 'John Doe',
            'company' => null,
            'blog' => '',
            'location' => null,
            'email' => null,
            'hireable' => null,
            'bio' => null,
            'twitter_username' => null,
            'public_repos' => 33,
            'public_gists' => 1,
            'followers' => 0,
            'following' => 0,
            'created_at' => '2025-08-25T04:20:00Z',
            'updated_at' => '2025-02-09T22:55:16Z',
            'private_gists' => 0,
            'total_private_repos' => 0,
            'owned_private_repos' => 0,
            'disk_usage' => 120903,
            'collaborators' => 0,
            'two_factor_authentication' => false,
            'plan' => [
                'name' => 'free',
                'space' => 9700000499,
                'collaborators' => 0,
                'private_repos' => 10000,
            ],
        ];
    }
}
