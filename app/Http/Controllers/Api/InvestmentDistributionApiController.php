<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Distribution\DistributeMoneyInvestmentRequest;
use App\Http\Resources\Distribution\DistributionRoundingCollection;
use App\Http\Resources\Distribution\InvestmentCollection;
use App\Http\Resources\Distribution\InvestmentResource;
use App\Services\AppDistributionService;
use Exception;


/**
 * @OA\Info(
 *     title="Test task API Documentation",
 *     version="1.0.0",
 *     description="API Documentation for the distribution service"
 * )
 */
class InvestmentDistributionApiController
{
    public function __construct(private readonly AppDistributionService $distributionService)
    {

    }
    /**
     * @OA\Post(
     *     path="/api/distribution",
     *     operationId="distribute",
     *     tags={"Distribution Service"},
     *     summary="Distributes an amount of money among multiple investors based on their respective investment rates.",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Request body for distributing money htorugh multiple investors. All provided rates sum of the values must equal to 1.",
     *         @OA\JsonContent(
     *             required={"amount", "rates"},
     *             @OA\Property(property="amount", type="integer", example=1000, description="The amount to distribute in cents"),
     *             @OA\Property(
     *                 property="rates",
     *                 type="object",
     *                 description="Investment distribution rates",
     *                 additionalProperties=@OA\Schema(
     *                     schema="InvestmentRate",
     *                     type="number",
     *                     format="float",
     *                     example=0.5
     *                 ),
     *                 example={
     *                     "investment_a": 0.5,
     *                     "investment_b": 0.3,
     *                     "investment_c": 0.2
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(response=201,description="Successful operation", @OA\JsonContent(type="object")),
     *     @OA\Response(response=422,description="Unprocessable Content", @OA\JsonContent(type="object")),
     *     @OA\Response(response=429,description="Too many requests", @OA\JsonContent(type="object")),
     *     @OA\Header(
     *         header="Accept",
     *         description="Specifies that the client expects a JSON response",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="application/json"
     *         )
     *    )
     * )
     *
     * @throws Exception
     */
    public function distribute(DistributeMoneyInvestmentRequest $request): InvestmentResource
    {
        return app(InvestmentResource::class, [
            'resource' => $this->distributionService->distributeInvestments(
                $request->input('amount'),
                $request->input('rates')
            )
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/distribution",
     *     operationId="getAllDistributions",
     *     tags={"Distribution Service"},
     *     summary="Get all distributions",
     *     @OA\Response(
     *      response=200,
     *      description="Successful operation",
     *      @OA\JsonContent(
     *          type="array",
     *          @OA\Items(
     *                  type="object",
     *                  @OA\Property(property="id", type="integer", example="6a7694b9-5be3-4951-964b-2693d6a8003f"),
     *                  @OA\Property(property="amount", type="integer", example=1000),
     *                  @OA\Property(
     *                      property="distribution",
     *                      type="object",
     *                      @OA\Property(property="investment_a", type="integer", example=500),
     *                      @OA\Property(property="investment_b", type="integer", example=300),
     *                      @OA\Property(property="investment_c", type="integer", example=200)
     *                  )
     *              )
     *      )
     *     ),
     *     @OA\Response(response=429,description="Too many requests", @OA\JsonContent(type="object")),
     *     @OA\Header(
     *         header="Accept",
     *         description="Specifies that the client expects a JSON response",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="application/json"
     *         )
     *    )
     * )
     *
     * @throws Exception
     */
    public function getAllDistributions(): InvestmentCollection
    {
        return app(InvestmentCollection::class, [
            'resource' => $this->distributionService->getAllDistributions()
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/distribution/roundings",
     *     operationId="getRoundingDetailsForDistributions",
     *     tags={"Distribution Service"},
     *     summary="Get all rouding details for all distributions",
     *     @OA\Response(
     *      response=200,
     *      description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  type="object",
     *                  @OA\Property(property="id", type="string", example="6a7694b9-5be3-4951-964b-2693d6a8003f"),
     *                  @OA\Property(
     *                      property="roundings",
     *                      type="object",
     *                      @OA\Property(property="investment_a", type="float", example=0.8),
     *                      @OA\Property(property="investment_b", type="float", example=0.7),
     *                      @OA\Property(property="investment_c", type="float", example=0.5)
     *                  ),
     *                  @OA\Property(property="total", type="integer", example=2),
     *              )
     *          )
     *     ),
     *     @OA\Response(response=429,description="Too many requests", @OA\JsonContent(type="object")),
     *     @OA\Header(
     *         header="Accept",
     *         description="Specifies that the client expects a JSON response",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="application/json"
     *         )
     *    )
     * )
     *
     * @throws Exception
     */
    public function getRoundingDetailsForDistributions(): DistributionRoundingCollection
    {
        return app(DistributionRoundingCollection::class, [
            'resource' => $this->distributionService->getAllDistributions()
        ]);
    }
}
