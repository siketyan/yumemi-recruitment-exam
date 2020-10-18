<?php

declare(strict_types=1);

namespace Track\Service\Dropout;

use Track\Model\Student;
use Track\Service\Dropout\Voter\DropoutVoterInterface;

class DropoutResolver
{
    /**
     * @var DropoutVoterInterface[]
     */
    private array $voters;

    public function __construct(
        array $voters
    ) {
        $this->voters = $voters;
    }

    public function resolve(Student $student): bool
    {
        foreach ($this->voters as $voter) {
            if ($voter->vote($student)) {
                return true;
            }
        }

        return false;
    }
}
