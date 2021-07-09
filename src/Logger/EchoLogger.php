<?php

namespace Alexsoft\Isup\Logger;

final class EchoLogger implements LoggerInterface
{
    public function write(string $string, bool $finishWithNewline = true)
    {
        echo $string;
        if ($finishWithNewline) {
            echo "\n";
        }
    }
}
