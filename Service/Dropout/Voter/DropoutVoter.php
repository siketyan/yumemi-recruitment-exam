<?php

declare(strict_types=1);

namespace Track\Service\Dropout\Voter;

use Track\Model\Score;
use Track\Model\Student;
use Track\Service\Failure\FailureResolver;

class DropoutVoter implements DropoutVoterInterface
{
    private FailureResolver $failureResolver;
    private int $numberOfFailuresToDropout;

    public function __construct(
        FailureResolver $failureResolver,
        int $numberOfFailuresToDropout
    ) {
        $this->failureResolver = $failureResolver;
        $this->numberOfFailuresToDropout = $numberOfFailuresToDropout;
    }

    /**
     * @inheritDoc
     */
    public function vote(Student $student): bool
    {
        $failures = array_filter(
            $student->getScores(),
            fn (Score $score): bool => $this->failureResolver->resolve($score),
        );

        return count($failures) >= $this->numberOfFailuresToDropout;
    }
}
