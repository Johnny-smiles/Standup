<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Support\Slack\Services\Slack;
use App\Support\Slack\Services\SlackJSONWebTokenDecoder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SlackLoginController extends Controller
{
    public function loginRedirect(Request $request): RedirectResponse
    {
        if (array_key_exists('error', $request->toArray())) {
            return redirect()->route('slack.landing');
        }

        $userArray = app(SlackJSONWebTokenDecoder::class)
            ->handle(
                (Slack::openId($request['code']))['id_token']
            );

        Auth::login(User::updateOrCreate(
            ['slack_id' => $userArray['https://slack.com/user_id']], [
                'email' => $userArray['email'],
                'name' => $userArray['name'],
                'avatar' => $userArray['picture'],
            ]));

        return redirect()->route('home');
    }
}
