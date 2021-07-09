<?php

declare(strict_types=1);

namespace Alexsoft\Isup\Logger;

interface LoggerInterface
{
    public function write(string $string, bool $finishWithNewline = true);
}
