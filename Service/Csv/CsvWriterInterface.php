<?php

declare(strict_types=1);

namespace Track\Service\Csv;

interface CsvWriterInterface
{
    /**
     * Writes the CSV to a string buffer.
     *
     * @param Csv $csv the CSV to write
     *
     * @return string the wrote CSV
     *
     * @throws CsvException
     */
    public function write(Csv $csv): string;
}
