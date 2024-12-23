<?php

namespace App\Entities;

class DistributionRoundingReminder
{
    public function __construct(private readonly int $roundingReminder)
    {
    }

    public function getRoundingReminderInCents(): int
    {
        return $this->roundingReminder;
    }

    public function getRoundingReminder(): float
    {
        return $this->roundingReminder / 100;
    }
}
