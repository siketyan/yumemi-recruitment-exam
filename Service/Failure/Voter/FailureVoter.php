<?php

declare(strict_types=1);

namespace Track\Service\Failure\Voter;

use Track\Model\Score;

class FailureVoter implements FailureVoterInterface
{
    private int $maximumScoreToFailure;

    public function __construct(
        int $maximumScoreToFailure
    ) {
        $this->maximumScoreToFailure = $maximumScoreToFailure;
    }

    /**
     * @inheritDoc
     */
    public function vote(Score $score): bool
    {
        return $score->getValue() <= $this->maximumScoreToFailure;
    }
}
