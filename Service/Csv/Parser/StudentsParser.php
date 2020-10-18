<?php

declare(strict_types=1);

namespace Track\Service\Csv\Parser;

use Track\Model\Score;
use Track\Model\Student;
use Track\Model\Subject;
use Track\Service\Csv\Csv;

class StudentsParser
{
    /**
     * Parses students from the CSV.
     *
     * @param Csv $csv the CSV to parse from
     *
     * @return Student[] the parsed students
     */
    public function parse(Csv $csv): array
    {
        $headers = $csv->getHeaders();
        array_shift($headers);

        $students = [];
        $subjects = array_map(
            fn (string $name): Subject => new Subject($name),
            $headers,
        );

        foreach ($csv->getRecords() as $row) {
            $students[] = new Student(
                array_shift($row),  // Student ID
                array_map(
                    fn (Subject $subject, string $value): Score => new Score($subject, (int) $value),
                    $subjects,
                    array_values($row),
                ),
            );
        }

        return $students;
    }
}
