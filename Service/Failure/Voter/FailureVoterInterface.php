<?php

declare(strict_types=1);

namespace Track\Service\Failure\Voter;

use Track\Model\Score;

interface FailureVoterInterface
{
    /**
     * Votes whether the record should be marked as failure or not.
     *
     * @param Score $score the score to vote for
     *
     * @return bool true if the score is failing
     */
    public function vote(Score $score): bool;
}
