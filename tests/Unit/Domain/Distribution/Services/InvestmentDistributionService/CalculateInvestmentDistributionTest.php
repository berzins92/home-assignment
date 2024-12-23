<?php

namespace Tests\Unit\Domain\Distribution\Services\InvestmentDistributionService;

use Domain\Distribution\Entities\Distribution;
use Domain\Distribution\Entities\InvestmentDistribution;
use Domain\Distribution\Services\InvestmentDistributionService;
use Domain\Distribution\ValueObjects\AmountValueObject;
use Domain\Distribution\ValueObjects\RatesValueObject;
use Illuminate\Support\Arr;
use Tests\TestCase;

class CalculateInvestmentDistributionTest extends TestCase
{
    public function testSuccess()
    {
        $service = new InvestmentDistributionService();
        $amountValueObject = new AmountValueObject(999);
        $ratesValueObject = new RatesValueObject([
            'investment_a' => 0.2,
            'investment_b' => 0.3,
            'investment_c' => 0.5,
        ]);

        $distribution = $service->calculateInvestmentDistribution($amountValueObject, $ratesValueObject);

        $this->assertInstanceOf(Distribution::class, $distribution);
        $this->assertEquals($amountValueObject->getAmount(), $distribution->getAmount());
        $this->assertEquals($ratesValueObject->getRates(), $distribution->getRates());
        $this->assertEquals($amountValueObject->getAmount(), $distribution->getTotalInvested());

        foreach ($distribution->getInvestments() as $investment) {
            $rate = $ratesValueObject->getRateByInvestor($investment->getInvestor());

            $originalInvestment = $amountValueObject->getAmount() * $rate->getRate();
            $amountDistributed = floor($amountValueObject->getAmount() * $rate->getRate());
            $reminder = bcsub($originalInvestment, $amountDistributed, 2);

            $this->assertEquals($rate->getRate(), $investment->getDistribution());
            $this->assertEquals($amountDistributed, $investment->getDistributedAmount());
            $this->assertEquals($reminder, $investment->getRoundingReminder());
            $this->assertInstanceOf(InvestmentDistribution::class, $investment);
        }
    }

    public function testSuccessWithRemainderTwo()
    {
        $service = new InvestmentDistributionService();
        $amountValueObject = new AmountValueObject(999);
        $ratesValueObject = new RatesValueObject([
            'investment_a' => 0.5,
            'investment_b' => 0.2,
            'investment_c' => 0.3,
        ]);

        $distribution = $service->calculateInvestmentDistribution($amountValueObject, $ratesValueObject);

        $this->assertEquals(2,  $distribution->getRemainder());
    }

    public function testSuccessWithRemainderZero()
    {
        $service = new InvestmentDistributionService();
        $amountValueObject = new AmountValueObject(1000);
        $ratesValueObject = new RatesValueObject([
            'investment_a' => 0.5,
            'investment_b' => 0.2,
            'investment_c' => 0.3,
        ]);

        $distribution = $service->calculateInvestmentDistribution($amountValueObject, $ratesValueObject);

        $this->assertEquals(0,  $distribution->getRemainder());
    }

    public function testSuccessWithManyInvestors()
    {
        $service = new InvestmentDistributionService();
        $amountValueObject = new AmountValueObject(1000);
        $ratesValueObject = new RatesValueObject([
            'investment_a' => 0.5,
            'investment_b' => 0.1,
            'investment_c' => 0.15,
            'investment_d' => 0.15,
            'investment_e' => 0.1,
        ]);

        $distribution = $service->calculateInvestmentDistribution($amountValueObject, $ratesValueObject);

        $this->assertInstanceOf(Distribution::class, $distribution);
        $this->assertEquals($amountValueObject->getAmount(), $distribution->getAmount());
        $this->assertEquals($ratesValueObject->getRates(), $distribution->getRates());

        foreach ($distribution->getInvestments() as $investment) {
            $rate = $ratesValueObject->getRateByInvestor($investment->getInvestor());

            $originalInvestment = $amountValueObject->getAmount() * $rate->getRate();
            $amountDistributed = floor($amountValueObject->getAmount() * $rate->getRate());
            $reminder = bcsub($originalInvestment, $amountDistributed, 2);

            $this->assertEquals($rate->getRate(), $investment->getDistribution());
            $this->assertEquals($amountDistributed, $investment->getDistributedAmount());
            $this->assertEquals($reminder, $investment->getRoundingReminderCents());
            $this->assertInstanceOf(InvestmentDistribution::class, $investment);
        }
    }
}
