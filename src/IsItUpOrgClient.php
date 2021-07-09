<?php

namespace Alexsoft\Isup;

final class IsItUpOrgClient
{
    public const URL = 'https://isitup.org/%s.json';

    public function getContent($domain)
    {
        $opts = [
            'http' => [
                'method' => 'GET',
                'header' => "User-Agent: github.com/alexsoft/isup.php\r\n",
            ],
        ];

        $contents = file_get_contents(
            sprintf(static::URL, $domain),
            false,
            stream_context_create($opts)
        );

        return json_decode($contents, true);
    }
}
