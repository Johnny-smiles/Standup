<?php

namespace App\Support\Slack\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class SlackGateway
{
    public function access(string $data): Response
    {
        return Http::asForm()->post('https://slack.com/api/oauth.v2.access', [
            'code' => $data,
            'client_id' => config('services.slack.client_id'),
            'client_secret' => config('services.slack.client_secret'),
            'grant_type' => 'authorization_code',
            'redirect_uri' => config('services.slack.callback'),
        ]);
    }

    public function refresh(string $refreshToken): Response
    {
        return Http::asForm()->post('https://slack.com/api/oauth.v2.access', [
            'client_id' => config('services.slack.client_id'),
            'client_secret' => config('services.slack.client_secret'),
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
        ]);
    }

    public function openId(string $data): Response
    {
        return Http::asForm()->post('https://slack.com/api/openid.connect.token', [
            'code' => $data,
            'client_id' => config('services.slack.client_id'),
            'client_secret' => config('services.slack.client_secret'),
            'grant_type' => 'authorization_code',
            'redirect_uri' => config('services.slack.redirect'),
        ]);
    }

    public function openModal(array $data, string $botToken): Response
    {
        return $this->client($botToken, '/views.open', $data);
    }

    public function postMessage(array $data, string $botToken): Response
    {
        return $this->client($botToken, '/chat.postMessage', $data);
    }

    public function postEphemeralMessage(array $data, string $botToken): Response
    {
        return $this->client($botToken, '/chat.postEphemeral', $data);
    }

    public function updateModal(array $data, string $botToken): Response
    {
        return $this->client($botToken, '/views.update', $data);
    }

    private function client(string $botToken, string $endpoint, array $data): Response
    {
        return Http::withToken($botToken)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post('https://slack.com/api'.$endpoint, $data);
    }
}
