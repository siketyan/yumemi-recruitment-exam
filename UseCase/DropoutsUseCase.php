<?php

declare(strict_types=1);

namespace Track\UseCase;

use Track\Model\Student;
use Track\Service\Dropout\DropoutResolver;

class DropoutsUseCase
{
    private DropoutResolver $dropoutResolver;

    public function __construct(
        DropoutResolver $dropoutResolver
    ) {
        $this->dropoutResolver = $dropoutResolver;
    }

    /**
     * Gets dropouts from the students.
     *
     * @param Student[] $students the students to get from
     *
     * @return Student[] the dropouts
     */
    public function getDropouts(array $students): array
    {
        return array_filter(
            $students,
            fn (Student $student): bool => $this->dropoutResolver->resolve($student),
        );
    }
}
