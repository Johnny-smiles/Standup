<?php

namespace App\Support\Slack\Blueprints\Stubs;

class DashboardLoginOauthStub
{
    public static array $responseFromSlack = [
        'accessTokenResponseBody' => [
            'ok' => true,
            'user' => [
                'name' => 'SLACK_USER_NAME',
                'id' => 'User_ID',
                'email' => 'SLACK_EMAIL_ADDRESS',
                'image_24' => 'https://avatars.slack-edge.com/2021-07-29/USER_IMAGE_24.jpg',
                'image_32' => 'https://avatars.slack-edge.com/2021-07-29/USER_IMAGE_32.jpg',
                'image_48' => 'https://avatars.slack-edge.com/2021-07-29/USER_IMAGE_48.jpg',
                'image_72' => 'https://avatars.slack-edge.com/2021-07-29/USER_IMAGE_72.jpg',
                'image_192' => 'https://avatars.slack-edge.com/2021-07-29/USER_IMAGE_192.jpg',
                'image_512' => 'https://avatars.slack-edge.com/2021-07-29/USER_IMAGE_512.jpg',
                'image_1024' => 'https://avatars.slack-edge.com/2021-07-29/USER_IMAGE_1024.jpg',
            ],
            'team' => [
                'id' => 'TEAM_ID',
                'name' => 'Economic Solutions',
                'domain' => 'econo-6',
                'image_102' => 'https://a.slack-edge.com/TEAM_IMAGE/img/avatars-teams/ava_0005-102.png',
                'image_132' => 'https://a.slack-edge.com/TEAM_IMAGE/img/avatars-teams/ava_0005-132.png',
                'image_230' => 'https://a.slack-edge.com/TEAM_IMAGE/img/avatars-teams/ava_0005-230.png',
                'image_34' => 'https://a.slack-edge.com/TEAM_IMAGE/img/avatars-teams/ava_0005-34.png',
                'image_44' => 'https://a.slack-edge.com/TEAM_IMAGE/img/avatars-teams/ava_0005-44.png',
                'image_68' => 'https://a.slack-edge.com/TEAM_IMAGE/img/avatars-teams/ava_0005-68.png',
                'image_88' => 'https://a.slack-edge.com/TEAM_IMAGE/img/avatars-teams/ava_0005-88.png',
                'image_default' => true,
            ],
            'access_token' => 'xoxp-BOT_TOKEN',
            'scope' => 'identity.basic,identity.email,identity.avatar,identity.team',
            'user_id' => 'User_ID',
            'team_id' => 'TEAM_ID',
            'enterprise_id' => null,
        ],
        'token' => 'xoxp-BOT_TOKEN',
        'refreshToken' => null,
        'expiresIn' => null,
        'id' => 'User_ID',
        'nickname' => null,
        'name' => 'SLACK_USER_NAME',
        'email' => 'SLACK_EMAIL_ADDRESS',
        'avatar' => 'https://avatars.slack-edge.com/2021-07-29/USER_IMAGE_192.jpg',
        'user' => [
            'ok' => true,
            'user' => [
                'name' => 'SLACK_USER_NAME',
                'id' => 'User_ID',
                'email' => 'SLACK_EMAIL_ADDRESS',
                'image_24' => 'https://avatars.slack-edge.com/2021-07-29/USER_IMAGE_24.jpg',
                'image_32' => 'https://avatars.slack-edge.com/2021-07-29/USER_IMAGE_32.jpg',
                'image_48' => 'https://avatars.slack-edge.com/2021-07-29/USER_IMAGE_48.jpg',
                'image_72' => 'https://avatars.slack-edge.com/2021-07-29/USER_IMAGE_72.jpg',
                'image_192' => 'https://avatars.slack-edge.com/2021-07-29/USER_IMAGE_192.jpg',
                'image_512' => 'https://avatars.slack-edge.com/2021-07-29/USER_IMAGE_512.jpg',
                'image_1024' => 'https://avatars.slack-edge.com/2021-07-29/USER_IMAGE_1024.jpg',
            ],
            'team' => [
                'id' => 'TEAM_ID',
                'name' => 'Economic Solutions',
                'domain' => 'econo-6',
                'image_102' => 'https://a.slack-edge.com/TEAM_IMAGE/img/avatars-teams/ava_0005-102.png',
                'image_132' => 'https://a.slack-edge.com/TEAM_IMAGE/img/avatars-teams/ava_0005-132.png',
                'image_230' => 'https://a.slack-edge.com/TEAM_IMAGE/img/avatars-teams/ava_0005-230.png',
                'image_34' => 'https://a.slack-edge.com/TEAM_IMAGE/img/avatars-teams/ava_0005-34.png',
                'image_44' => 'https://a.slack-edge.com/TEAM_IMAGE/img/avatars-teams/ava_0005-44.png',
                'image_68' => 'https://a.slack-edge.com/TEAM_IMAGE/img/avatars-teams/ava_0005-68.png',
                'image_88' => 'https://a.slack-edge.com/TEAM_IMAGE/img/avatars-teams/ava_0005-88.png',
                'image_default' => true,
            ],
        ],
        'organization_id' => 'TEAM_ID',
    ];
}
