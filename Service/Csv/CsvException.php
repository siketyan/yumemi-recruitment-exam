<?php

declare(strict_types=1);

namespace Track\Service\Csv;

use RuntimeException;
use Throwable;

class CsvException extends RuntimeException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            printf('Failed to read from or write to CSV: %s', $message),
            $code,
            $previous
        );
    }
}
