<?php
namespace Tests\Feature\Api\InvestmentDistributionApiController;

use Illuminate\Support\Arr;
use Tests\TestCase;

class GetAllDistributionsTest extends TestCase
{
    public function testSuccess()
    {
        $response = $this->json('GET','/api/distribution');

        foreach ($response->json('data') as $item) {
            $this->assertArrayHasKey('id', $item);
            $this->assertArrayHasKey('amount', $item);
            $this->assertIsInt(Arr::get($item, 'amount'));
            $this->assertArrayHasKey('amount', $item);
            $this->assertIsArray(Arr::get($item, 'distribution'));

            foreach (Arr::get($item, 'distribution') as $distribution) {
                $this->assertIsInt($distribution);
            }

        }

        $response->assertStatus(200);
    }
}
