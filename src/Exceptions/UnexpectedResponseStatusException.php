<?php

namespace Alexsoft\Isup\Exceptions;

use RuntimeException;

class UnexpectedResponseStatusException extends RuntimeException
{
    public static function withStatus($status)
    {
        return new self("Unexpected status [{$status}]");
    }
}
