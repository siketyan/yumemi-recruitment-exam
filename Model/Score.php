<?php

declare(strict_types=1);

namespace Track\Model;

class Score
{
    private Subject $subject;
    private int $value;

    public function __construct(
        Subject $subject,
        int $value
    ) {
        $this->subject = $subject;
        $this->value = $value;
    }

    public function getSubject(): Subject
    {
        return $this->subject;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
