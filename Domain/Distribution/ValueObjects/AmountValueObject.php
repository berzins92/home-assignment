<?php

namespace Domain\Distribution\ValueObjects;

use InvalidArgumentException;

/**
 * Investment amount to distribute
 */
class AmountValueObject
{
    public function __construct(private readonly int $value)
    {
        if ($value < 0) {
            throw new InvalidArgumentException('Amount must be larger than 0');
        }
    }

    public function getAmount(): int
    {
        return $this->value;
    }
}
