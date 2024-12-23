<?php

namespace Tests\Feature\Api\InvestmentDistributionApiController;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Tests\TestCase;

class DistributeTest extends TestCase
{

    use WithFaker;
    /**
     * A basic feature test example.
     */
    public function testSuccess(): void
    {
        $randomAmount = random_int(900, 10000000);

        $investments = [
            'investment_a' => 0.5,
            'investment_b' => 0.3,
            'investment_c' => 0.2,
        ];

        $response = $this->json('POST', '/api/distribution', [
            'amount' => $randomAmount,
            'rates' => $investments
        ]);

        $response->assertStatus(201);

        // TODO add more asserts

        $response->assertJsonFragment([
            'amount' => $randomAmount,
        ]);

        foreach ($response->json('data.distribution') as $key => $value) {
            $this->assertEquals(floor(Arr::get($investments, $key) * $randomAmount), $value);
        }
    }

    public function testSuccessWithProvidedTestCaseOne()
    {
        $amount = 1000;

        $investments = [
            'investment_a' => 0.5,
            'investment_b' => 0.3,
            'investment_c' => 0.2,
        ];

        $response = $this->json('POST', '/api/distribution', [
            'amount' => $amount,
            'rates' => $investments
        ]);

        // TODO add more asserts

        $response->assertJsonFragment([
            'amount' => $amount,
        ]);

        foreach ($response->json('data.distribution') as $key => $value) {
            $this->assertEquals(floor(Arr::get($investments, $key) * $amount), $value);
        }

        $response->assertStatus(201);
    }

    public function testSuccessWithProvidedTestCaseTwo()
    {
        $amount = 999;

        $investments = [
            'investment_a' => 0.5,
            'investment_b' => 0.3,
            'investment_c' => 0.2,
        ];

        $response = $this->json('POST', '/api/distribution', [
            'amount' => $amount,
            'rates' => $investments
        ]);

        // TODO add more asserts

        $response->assertJsonFragment([
            'amount' => $amount,
        ]);

        foreach ($response->json('data.distribution') as $key => $value) {
            $this->assertEquals(floor(Arr::get($investments, $key) * $amount), $value);
        }

        $response->assertStatus(201);
    }

    public function testFailureWhenRatesIsLessThanOne()
    {
        $randomAmount = rand(900, 10000000);

        $response = $this->json('POST', '/api/distribution', [
            'amount' => $randomAmount,
            'rates' => [
                'investment_a' => 0.5,
                'investment_b' => 0.3,
                'investment_c' => 0.25,
            ]
        ]);

        $response->assertJson([
            'message' => 'The total sum of the investment rates must be equal to 1.',
            'errors' => [
                'rates' => [
                    'The total sum of the investment rates must be equal to 1.'
                ]
            ],
        ]);
        $response->assertUnprocessable();
    }

    public function testFailureWhenRatesIsMoreThanOne()
    {
        $randomAmount = rand(900, 10000000);

        $response = $this->json('POST', '/api/distribution', [
            'amount' => $randomAmount,
            'rates' => [
                'investment_a' => 0.5,
                'investment_b' => 0.8,
                'investment_c' => 0.25,
            ]
        ]);

        $response->assertJson([
            'message' => 'The total sum of the investment rates must be equal to 1.',
            'errors' => [
                'rates' => [
                    'The total sum of the investment rates must be equal to 1.'
                ]
            ],
        ]);
        $response->assertUnprocessable();
    }

    public function testFailureWhenAmountIsNotInt()
    {
        $randomAmount = $this->faker->randomFloat(2);

        $response = $this->json('POST', '/api/distribution', [
            'amount' => $randomAmount,
            'rates' => [
                'investment_a' => 0.5,
                'investment_b' => 0.3,
                'investment_c' => 0.2,
            ]
        ]);


        $response->assertJson([
            "message" => "The amount field must be an integer.",
            "errors" => [
                "amount" => [
                    "The amount field must be an integer."
                ]
            ],
        ]);

        $response->assertUnprocessable();
    }
}
