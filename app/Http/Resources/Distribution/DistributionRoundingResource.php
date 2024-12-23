<?php

namespace App\Http\Resources\Distribution;

use App\Models\InvestmentDistribution;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DistributionRoundingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $total = $this->distributions->sum(fn (InvestmentDistribution $distribution) => $distribution->rounding_reminder->getRoundingReminder());

        return [
            'id' => $this->investment_id,
            'roundings' => $this->transformRounding(),
            'total' => $total,
        ];
    }

    /**
     * Transform the distribution into the required format.
     *
     * @return array<string, int>
     */
    protected function transformRounding(): array
    {
        return $this->distributions->mapWithKeys(fn (InvestmentDistribution $item) => [
            $item->investor_name => $item->rounding_reminder->getRoundingReminder(),
        ])->toArray();
    }
}
