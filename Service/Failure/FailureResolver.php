<?php

declare(strict_types=1);

namespace Track\Service\Failure;

use Track\Model\Score;
use Track\Service\Failure\Voter\FailureVoterInterface;

class FailureResolver
{
    /**
     * @var FailureVoterInterface[] the voters to use
     */
    private array $voters;

    /**
     * @param FailureVoterInterface[] $voters the voters to use
     */
    public function __construct(
        array $voters
    ) {
        $this->voters = $voters;
    }

    /**
     * Resolves the score is failing grade or not.
     *
     * @param Score $score the score to resolve for
     *
     * @return bool true if the score is failing grade
     */
    public function resolve(Score $score): bool
    {
        foreach ($this->voters as $voter) {
            if ($voter->vote($score)) {
                return true;
            }
        }

        return false;
    }
}
