<?php
namespace Domain\Distribution\Services;

use Domain\Distribution\Entities\Distribution;
use Domain\Distribution\ValueObjects\AmountValueObject;
use Domain\Distribution\ValueObjects\RatesValueObject;

interface InvestmentDistributionServiceInterface
{
    public function calculateInvestmentDistribution(AmountValueObject $amountValueObject, RatesValueObject $ratesValueObject): Distribution;
}
