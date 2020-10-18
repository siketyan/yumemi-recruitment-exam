<?php

declare(strict_types=1);

namespace Track\Service\Csv\Builder;

use Track\Model\Mean;
use Track\Service\Csv\Csv;

class MeansBuilder
{
    private int $numberOfDigits;

    public function __construct(
        int $numberOfDigits
    ) {
        $this->numberOfDigits = $numberOfDigits;
    }

    /**
     * Builds a CSV from the means.
     *
     * @param Mean[] $means the means to build from
     *
     * @return Csv the built CSV
     */
    public function build(array $means): Csv
    {
        $headers = ['ID', 'Mean'];
        $records = array_map(
            fn (Mean $mean): array => [
                $mean->getStudent()->getId(),
                sprintf(
                    '%.' . $this->numberOfDigits . 'f',
                    $mean->getValue(),
                ),
            ],
            $means,
        );

        return new Csv($headers, $records);
    }
}
