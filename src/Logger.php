<?php

namespace Alexsoft\Isup;

final class Logger
{
    public function write($string, $finishWithNewline = true)
    {
        echo $string;
        if ($finishWithNewline) {
            echo "\n";
        }
    }
}
