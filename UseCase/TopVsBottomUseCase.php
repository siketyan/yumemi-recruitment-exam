<?php

declare(strict_types=1);

namespace Track\UseCase;

use Track\Model\Mean;
use Track\Model\Student;
use Track\Service\Mean\MeanCalculator;

class TopVsBottomUseCase
{
    private MeanCalculator $meanCalculator;

    public function __construct(
        MeanCalculator $meanCalculator
    ) {
        $this->meanCalculator = $meanCalculator;
    }

    /**
     * Calculates means of the students.
     *
     * @param Student[] $students the students to calculate from
     *
     * @return Mean[] the calculated means
     */
    public function calculateMeans(array $students): array
    {
        return array_map(
            fn (Student $student): Mean => $this->meanCalculator->calculate($student),
            $students,
        );
    }

    /**
     * Gets means on the top of values.
     *
     * @param Mean[] $means the means to get from
     *
     * @return Mean[] the top means
     */
    public function getTops(array $means): array
    {
        return $this->filterByMeanValue(
            $means,
            max(...$this->getMeanValues($means)),
        );
    }

    /**
     * Gets means on the bottom of values.
     *
     * @param Mean[] $means the means to get from
     *
     * @return Mean[] the bottom means
     */
    public function getBottoms(array $means): array
    {
        return $this->filterByMeanValue(
            $means,
            min(...$this->getMeanValues($means)),
        );
    }

    /**
     * @param Mean[] $means
     *
     * @return float[]
     */
    private function getMeanValues(array $means): array
    {
        return array_map(
            fn (Mean $mean): float => $mean->getValue(),
            $means,
        );
    }

    /**
     * Filters the means by the value.
     *
     * @param Mean[] $means
     * @param float  $value
     *
     * @return Mean[]
     */
    private function filterByMeanValue(array $means, float $value): array
    {
        return array_filter(
            $means,
            fn (Mean $mean): bool => $mean->getValue() === $value,
        );
    }
}
