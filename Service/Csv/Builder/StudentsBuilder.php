<?php

declare(strict_types=1);

namespace Track\Service\Csv\Builder;

use Track\Model\Student;
use Track\Service\Csv\Csv;

class StudentsBuilder
{
    /**
     * Builds a CSV from the students.
     *
     * @param Student[] $students the students to build from
     *
     * @return Csv the built CSV
     */
    public function build(array $students): Csv
    {
        $headers = ['ID'];
        $records = array_map(
            fn (Student $student): array => [
                $student->getId(),
            ],
            $students,
        );

        return new Csv($headers, $records);
    }
}
