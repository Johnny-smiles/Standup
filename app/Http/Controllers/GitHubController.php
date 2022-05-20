<?php

namespace App\Http\Controllers;

use App\Support\GitHub\Services\GitHub;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class GitHubController extends Controller
{
    public function githubOauthRedirect(Request $request): RedirectResponse
    {
        $token = GitHub::openId($request['code']);

        parse_str($token, $parsedToken);

        $gitHubUser = json_decode(GitHub::user($parsedToken['access_token']), true);

        $user = auth()->user();

        $user->github_token && $user->github_token != $parsedToken
            ? $user->update([
                'github_username' => $gitHubUser['login'],
                'github_token' => $parsedToken['access_token'],
                'github_token_changed_at' => now(),
            ])
            : $user->update([
                'github_username' => $gitHubUser['login'],
                'github_token' => $parsedToken['access_token'],
                'github_token_added_at' => now(),
            ]);

        return redirect()->route('alert', [
            'alert' => 'Github',
            'message' => 'GitHub',
            'action' => 'Now Linked!',
        ]);
    }

    public function deleteGitHubLink(): RedirectResponse
    {
        auth()->user()->update([
            'github_username' => null,
            'github_token' => null,
            'github_token_deleted_at' => now(),
        ]);

        Cache::forget(auth()->user()->getKey().'.github-issues');

        return redirect()->route('alert', [
            'alert' => 'Github',
            'message' => 'GitHub',
            'action' => 'Now Unlinked!',
        ]);
    }
}
