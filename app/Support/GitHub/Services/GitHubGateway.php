<?php

namespace App\Support\GitHub\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class GitHubGateway
{
    public function openId(string $data): Response
    {
        return Http::asForm()->post('https://github.com/login/oauth/access_token', [
            'code' => $data,
            'client_id' => config('services.github.client_id'),
            'client_secret' => config('services.github.client_secret'),
            'redirect_uri' => config('services.github.redirect'),
        ]);
    }

    public function user($token): Response
    {
        return Http::withToken($token)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])
            ->get('https://api.github.com/user');
    }

    public function githubIssuesQuery(array $variables, string $token)
    {
        return Http::withToken($token)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'User-Agent' => 'Standups',
            ])
            ->post(
                'https://api.github.com/graphql',
                [
                    'query' => "query { viewer { issues(last: {$variables['number_of_issues']}, states: {$variables['state']} ) { nodes { title, number, repository { name } } } } }",
                ]
            );
    }
}
