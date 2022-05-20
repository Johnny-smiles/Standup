<?php

namespace App\Support\Slack\Blueprints\Stubs\Oauth;

class Oauth
{
    public static array $requestOauthAuthorize = [
        'code' => 'Code...2258651156659.3031574108401',
    ];

    public static string $responseOauthAuthorize = '"ok":true,"access_token":"xoxp-token-12345","token_type":"Bearer","id_token":"Token..."}}} ]';

    public static function responseLoginAccess()
    {
        return [
            'iss' => 'https://slack.com',
            'sub' => 'SlackId',
            'aud' => config('services.slack.client_id'),
            'exp' => 1634767494,
            'iat' => 1634767194,
            'auth_time' => 1634767194,
            'nonce' => '',
            'at_hash' => 'Cry0tiSASSGwWrRU0JOieQ',
            'https://slack.com/team_id' => 'TEAM_ID',
            'https://slack.com/user_id' => 'User_ID',
            'email' => 'Jsmiles@gmail.com',
            'email_verified' => true,
            'date_email_verified' => 1625839369,
            'locale' => 'en-US',
            'name' => 'Johnny Smiles',
            'picture' => 'googlePics.com',
            'given_name' => 'John',
            'family_name' => 'Anderson',
            'https://slack.com/team_name' => 'Economic Solutions',
            'https://slack.com/team_domain' => 'econo-6',
            'https://slack.com/team_image_230' => 'googlePics.com',
            'https://slack.com/team_image_default' => true,
        ];
    }
}
