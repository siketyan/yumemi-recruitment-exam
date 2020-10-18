<?php

declare(strict_types=1);

namespace Track\Service\Csv;

use League\Csv\Exception;
use League\Csv\Reader;
use League\Csv\Writer;

class LeagueCsvReaderWriter implements CsvReaderInterface, CsvWriterInterface
{
    /**
     * @inheritDoc
     */
    public function read(string $file): Csv
    {
        try {
            $reader = Reader::createFromPath($file);
            $reader->setHeaderOffset(0);

            return new Csv(
                $reader->getHeader(),
                iterator_to_array($reader->getRecords()),
            );
        } catch (Exception $e) {
            throw new CsvException(
                $e->getMessage(),
                $e->getCode(),
                $e,
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function write(Csv $csv): string
    {
        try {
            $writer = Writer::createFromString();
            $writer->insertOne($csv->getHeaders());
            $writer->insertAll($csv->getRecords());

            return $writer->getContent();
        } catch (Exception $e) {
            throw new CsvException(
                $e->getMessage(),
                $e->getCode(),
                $e,
            );
        }
    }
}
