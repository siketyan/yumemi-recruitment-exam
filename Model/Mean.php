<?php

declare(strict_types=1);

namespace Track\Model;

class Mean
{
    private Student $student;
    private float $value;

    public function __construct(
        Student $student,
        float $value
    ) {
        $this->student = $student;
        $this->value = $value;
    }

    public function getStudent(): Student
    {
        return $this->student;
    }

    public function getValue(): float
    {
        return $this->value;
    }
}
