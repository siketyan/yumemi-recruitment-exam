<?php

declare(strict_types=1);

namespace Track\Service\Dropout\Voter;

use Track\Model\Student;

interface DropoutVoterInterface
{
    /**
     * Votes whether the student is dropout or not.
     *
     * @param Student $student the student to vote for
     *
     * @return bool true if the student is dropout
     */
    public function vote(Student $student): bool;
}
