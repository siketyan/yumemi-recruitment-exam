<?php

declare(strict_types=1);

namespace Track\Service\Csv;

class Csv
{
    /**
     * @var string[]
     */
    private array $headers;

    /**
     * @var string[][]
     */
    private array $records;

    /**
     * @param string[]   $headers
     * @param string[][] $records
     */
    public function __construct(
        array $headers,
        array $records
    ) {
        $this->headers = $headers;
        $this->records = $records;
    }

    /**
     * @return string[]
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return string[][]
     */
    public function getRecords(): array
    {
        return $this->records;
    }
}
