<?php

declare(strict_types=1);

namespace Alexsoft\Isup\Client;

use Alexsoft\Isup\Exceptions\ApiException;
use JsonException;

final class IsItUpOrgClient implements ClientInterface
{
    private const URL = 'https://isitup.org/%s.json';

    public function getContent(string $domain): array
    {
        $opts = [
            'http' => [
                'method' => 'GET',
                'header' => "User-Agent: github.com/alexsoft/isup.php\r\n",
            ],
        ];

        $contents = file_get_contents(
            sprintf(self::URL, $domain),
            false,
            stream_context_create($opts)
        );

        try {
            return json_decode($contents, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new ApiException($contents, 0, $exception);
        }
    }
}
