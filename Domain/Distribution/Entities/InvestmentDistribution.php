<?php

namespace Domain\Distribution\Entities;

class InvestmentDistribution implements InvestmentDistributionInterface
{
    private int $distributionRoundingReminderInCents;

    public function __construct(
        private readonly string $investor,
        private readonly int    $distributedAmount,
        private readonly float  $distribution,
    )
    {

    }

    public function getInvestor(): string
    {
        return $this->investor;
    }

    public function getDistributedAmount(): int
    {
        return $this->distributedAmount;
    }

    public function getDistribution(): float
    {
        return $this->distribution;
    }

    public function setRoundingReminderInCents(float $totalInvestmentAmount): void
    {
        $this->distributionRoundingReminderInCents = ($totalInvestmentAmount * pow(10, 2)) % 100;
    }

    public function getRoundingReminderCents(): int
    {
        return $this->distributionRoundingReminderInCents;
    }

    public function getRoundingReminder(): float
    {
        return $this->distributionRoundingReminderInCents / pow(10, 2);
    }
}
