<?php

namespace App\Http\Resources\Distribution;

use App\Models\InvestmentDistribution;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvestmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->investment_id,
            'amount' => $this->amount,
            'distribution' => $this->transformDistribution(),
        ];
    }

    /**
     * Transform the distribution into the required format.
     *
     * @return array<string, int>
     */
    protected function transformDistribution(): array
    {
        return $this->distributions->mapWithKeys(function (InvestmentDistribution $item) {
            return [
                $item->investor_name => $item->distributed_amount
            ];
        })->toArray();
    }
}
