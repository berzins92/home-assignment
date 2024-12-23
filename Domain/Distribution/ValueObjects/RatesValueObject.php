<?php

namespace Domain\Distribution\ValueObjects;

/**
 * Investment rates array
 */
class RatesValueObject
{
    public function __construct(private array $rates)
    {
        $this->rates = array_map(fn($rate, $key) => new RateValueObject($key, $rate), $rates, array_keys($rates));
    }

    /**
     * @return RateValueObject[]
     */
    public function getRates(): array
    {
        return $this->rates;
    }

    public function getRateByInvestor(string $investor): ?RateValueObject
    {
        return collect($this->rates)->filter(function (RateValueObject $rate) use ($investor) {
            return $rate->getInvestor() === $investor;
        })->first();
    }
}
