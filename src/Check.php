<?php

declare(strict_types=1);

namespace Alexsoft\Isup;

use Alexsoft\Isup\Client\ClientInterface;
use Alexsoft\Isup\Exceptions\ApiException;
use Alexsoft\Isup\Exceptions\UnexpectedResponseStatusException;
use Alexsoft\Isup\Logger\LoggerInterface;

class Check
{
    private const STATUS_WEBSITE_IS_UP = 1;
    private const STATUS_WEBSITE_IS_DOWN = 2;
    private const STATUS_NOT_WEBSITE = 3;
    private const STATUS_API_ERROR = 4;
    private const MESSAGES = [
        self::STATUS_WEBSITE_IS_UP => "It's just you. %s is up.",
        self::STATUS_WEBSITE_IS_DOWN => "It's not just you! %s looks down from here.",
        self::STATUS_NOT_WEBSITE => "Huh? %s doesn't look like a site.",
        self::STATUS_API_ERROR => "Sorry! API is not available right now!",
    ];

    private ClientInterface $client;

    private LoggerInterface $logger;

    public function __construct(ClientInterface $client, LoggerInterface $logger)
    {
        $this->client = $client;
        $this->logger = $logger;
    }

    public function check($domain): void
    {
        $status = $this->getStatus($domain);

        $this->logger->write(sprintf($this->getMessagePattern($status), $domain));
    }

    private function getStatus($domain): int
    {
        try {
            $content = $this->client->getContent($domain);

            return (int)$content['status_code'];
        } catch (ApiException $exception) {
            return self::STATUS_API_ERROR;
        }
    }

    /**
     * @throws UnexpectedResponseStatusException
     */
    private function getMessagePattern(int $status): string
    {
        if (!array_key_exists($status, self::MESSAGES)) {
            throw UnexpectedResponseStatusException::withStatus($status);
        }

        return self::MESSAGES[$status];
    }
}
