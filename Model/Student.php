<?php

declare(strict_types=1);

namespace Track\Model;

class Student
{
    private string $id;

    /**
     * @var Score[]
     */
    private array $scores;

    /**
     * @param string $id
     * @param array  $scores
     */
    public function __construct(
        string $id,
        array $scores
    ) {
        $this->id = $id;
        $this->scores = $scores;
    }

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return Score[]
     */
    public function getScores(): array
    {
        return $this->scores;
    }
}
