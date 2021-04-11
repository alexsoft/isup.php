<?php

declare(strict_types=1);

namespace Alexsoft\Isup\Client;

interface ClientInterface
{
    public function getContent(string $domain): array;
}
