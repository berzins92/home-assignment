<?php

namespace Domain\Distribution\Entities;

use Domain\Distribution\ValueObjects\RateValueObject;

class Distribution
{
    private float $remainder = 0;

    /** @var InvestmentDistributionInterface[] $investments */
    private array $investments;

    /** @param RateValueObject[] $rates */
    public function __construct(private readonly int $amount, private readonly array $rates)
    {

    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    /** @return RateValueObject[] */
    public function getRates(): array
    {
        return $this->rates;
    }

    private function addRemainder(float $remainder): void
    {
        $this->remainder = bcadd($this->remainder, $remainder, 2);
    }

    public function getRemainder(): float
    {
        return $this->remainder;
    }

    public function addInvestment(InvestmentDistributionInterface $investment): void
    {
        $this->investments[] = $investment;
        $this->addRemainder($investment->getRoundingReminder());
    }

    /** @return InvestmentDistributionInterface[] */
    public function getInvestments(): array
    {
        return $this->investments;
    }

    public function getDistributedTotalAmount(): int
    {
        return array_sum(array_map(fn(InvestmentDistributionInterface $investment) => $investment->getDistributedAmount(), $this->getInvestments()));
    }

    public function getTotalInvested(): int
    {
        return $this->getDistributedTotalAmount() + $this->getRemainder();
    }
}
