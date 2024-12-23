<?php

namespace Domain\Distribution\ValueObjects;

/**
 * Investment rate and investor
 */
class RateValueObject
{
    public function __construct(
        private readonly string $investor,
        private readonly float  $rate
    )
    {
    }

    public function getInvestor(): string
    {
        return $this->investor;
    }

    public function getRate(): float
    {
        return $this->rate;
    }
}
