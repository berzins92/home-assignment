<?php

namespace Domain\Distribution\Repositories;

use App\Models\Investment;
use App\Models\InvestmentDistribution;
use Domain\Distribution\Entities\Distribution;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InvestmentDistributionRepository
{
    public function create(Distribution $distribution): Investment
    {
        return DB::transaction(function () use ($distribution) {
            $investment = new Investment();
            $investment->investment_id = Str::uuid()->toString();
            $investment->amount = $distribution->getAmount();
            $investment->save();

            foreach ($distribution->getInvestments() as $investmentDistribution) {
                $investmentDistributionRecord = new InvestmentDistribution();
                $investmentDistributionRecord->investment_id = $investment->investment_id;
                $investmentDistributionRecord->investor_name = $investmentDistribution->getInvestor();
                $investmentDistributionRecord->distributed_amount = $investmentDistribution->getDistributedAmount();
                $investmentDistributionRecord->rounding_reminder = $investmentDistribution->getRoundingReminderCents();
                $investmentDistributionRecord->save();
            }


            return $investment;
        });
    }

    /** @return Collection<Investment> */
    public function getAll(): Collection
    {
        return Investment::with('distributions')->get();
    }
}
