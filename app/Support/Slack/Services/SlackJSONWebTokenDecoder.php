<?php

namespace App\Support\Slack\Services;

class SlackJSONWebTokenDecoder
{
    public function handle($response): array
    {
        return collect(
            json_decode(
                base64_decode(
                    str_replace(
                        '_',
                        '/',
                        str_replace(
                            '-',
                            '+',
                            explode(
                                '.',
                                $response
                            )[1]
                        )
                    )
                )
            )
        )->toArray();
    }
}
