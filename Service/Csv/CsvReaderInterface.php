<?php

declare(strict_types=1);

namespace Track\Service\Csv;

interface CsvReaderInterface
{
    /**
     * Reads a CSV from the file.
     *
     * @param string $file the file to read from
     *
     * @return Csv the read CSV
     *
     * @throws CsvException
     */
    public function read(string $file): Csv;
}
