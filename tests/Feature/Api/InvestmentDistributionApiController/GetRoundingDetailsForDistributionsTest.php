<?php
namespace Tests\Feature\Api\InvestmentDistributionApiController;

use Illuminate\Support\Arr;
use Tests\TestCase;

class GetRoundingDetailsForDistributionsTest extends TestCase
{
    public function testSuccess()
    {
        $response = $this->json('GET','/api/distribution/roundings');

        foreach ($response->json('data') as $item) {
            $this->assertArrayHasKey('id', $item);
            $this->assertArrayHasKey('total', $item);
            $this->assertArrayHasKey('roundings', $item);
            $this->assertEquals(
                array_sum(Arr::get($item, 'roundings')), Arr::get($item, 'total')
            );
        }

        $response->assertStatus(200);
    }
}
