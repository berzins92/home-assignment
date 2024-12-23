<?php

namespace App\Services;

use App\Models\Investment;
use Domain\Distribution\Repositories\InvestmentDistributionRepository;
use Domain\Distribution\Services\InvestmentDistributionService;
use Domain\Distribution\ValueObjects\AmountValueObject;
use Domain\Distribution\ValueObjects\RatesValueObject;
use Exception;
use Illuminate\Support\Collection;

class AppDistributionService
{
    public function __construct(
        private readonly InvestmentDistributionService    $investmentService,
        private readonly InvestmentDistributionRepository $repository
    )
    {

    }

    /**
     * Distribute and save given investments using InvestmentDistributionService (Domain/Distribute) layer
     *
     * If this service is used somewhere else apart from API, then add data validation to it.
     *
     * @throws Exception
     */
    public function distributeInvestments(int $amount, array $rates): Investment
    {
        $distribution = $this->investmentService->calculateInvestmentDistribution(
            new AmountValueObject($amount),
            new RatesValueObject($rates)
        );

        return $this->repository->create($distribution);
    }

    /** @return Collection<Investment> */
    public function getAllDistributions(): Collection
    {
        return $this->repository->getAll();
    }
}
