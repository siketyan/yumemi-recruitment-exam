<?php

declare(strict_types=1);

namespace Track\Service\Mean;

use Track\Model\Mean;
use Track\Model\Score;
use Track\Model\Student;

class MeanCalculator
{
    private int $numberOfDigits;

    public function __construct(
        int $numberOfDigits
    ) {
        $this->numberOfDigits = $numberOfDigits;
    }

    /**
     * Calculates a mean of the student.
     *
     * @param Student $student the student to calculate for
     *
     * @return Mean the calculated mean
     */
    public function calculate(Student $student): Mean
    {
        $scores = $student->getScores();
        $count = count($scores);
        $sum = array_sum(
            array_map(
                fn (Score $score): int => $score->getValue(),
                $student->getScores(),
            ),
        );

        return new Mean(
            $student,
            round(
                (float) $sum / $count,
                $this->numberOfDigits,
            ),
        );
    }
}
