<?php

namespace Alexsoft\Isup;

use Alexsoft\Isup\Exceptions\UnexpectedResponseStatusException;

class Check
{
    const STATUS_WEBSITE_IS_UP = 1;
    const STATUS_WEBSITE_IS_DOWN = 2;
    const STATUS_NOT_WEBSITE = 3;
    const STATUS_API_ERROR = 4;

    private $messages = [
        self::STATUS_WEBSITE_IS_UP => "It's just you. %s is up.",
        self::STATUS_WEBSITE_IS_DOWN => "It's not just you! %s looks down from here.",
        self::STATUS_NOT_WEBSITE => "Huh? %s doesn't look like a site.",
        self::STATUS_API_ERROR => "Sorry! API is not available right now!"
    ];

    /** @var IsItUpOrgClient */
    private $client;

    /** @var Logger */
    private $logger;

    public function __construct(IsItUpOrgClient $client, Logger $logger)
    {
        $this->client = $client;
        $this->logger = $logger;
    }

    public function check($domain)
    {
        $status = $this->getStatus($domain);

        $this->logger->write(sprintf($this->getMessagePattern($status), $domain));
    }

    private function getStatus($domain)
    {
        $content = $this->client->getContent($domain);

        if (false === $content) {
            return static::STATUS_API_ERROR;
        }

        return $content['status_code'];
    }

    /**
     * @param int $status
     * @return string
     * @throws UnexpectedResponseStatusException
     */
    private function getMessagePattern($status)
    {
        if (!array_key_exists($status, $this->messages)) {
            throw UnexpectedResponseStatusException::withStatus($status);
        }

        return $this->messages[$status];
    }
}
