<?php
namespace Domain\Distribution\Entities;

interface InvestmentDistributionInterface
{
    public function getInvestor(): string;

    public function getDistributedAmount(): int;

    public function getDistribution(): float;
}
