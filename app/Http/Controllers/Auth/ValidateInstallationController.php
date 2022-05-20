<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ValidateInstallationRequest;
use App\Models\Team;
use App\Models\User;
use App\Support\Slack\Services\Slack;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ValidateInstallationController extends Controller
{
    public function __invoke(ValidateInstallationRequest $request): View|RedirectResponse
    {
        if ($request->code === config('services.slack.verify_code')) {
            $access = json_decode(Slack::access(session()->pull('code')), true);

            $team = Team::updateOrCreate(
                ['team_id' => $access['team']['id']],
                [
                    'name' => $access['team']['name'],
                    'bot_token' => $access['access_token'],
                    'refresh_token' => $access['refresh_token'],
                ]
            );

            $user = User::updateOrCreate(
                ['slack_id' => $access['authed_user']['id']],
                [
                    'is_admin' => true,
                ]
            );

            $team->channel()->create(
                [
                    'slack_channel_id' => 'New-'.$team->team_id.'-Channel',
                    'name' => 'New-'.$team->name.'-Channel',
                ]
            );

            $user->teams()->syncWithoutDetaching($team);

            return redirect(config('services.slack.access_redirect'));
        }

        return view('oauth')->with(['header' => 'Please Enter Valid Verification Code']);
    }
}
