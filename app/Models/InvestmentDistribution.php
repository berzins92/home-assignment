<?php

namespace App\Models;

use App\Entities\DistributionRoundingReminder;
use App\Models\Traits\Uuids;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $investment_id
 * @property string $investment_distribution_id
 * @property string $investor_name
 * @property int $distributed_amount
 * @property DistributionRoundingReminder $rounding_reminder
 * @property string $created_at
 * @property string $updated_at
 */
class InvestmentDistribution extends Model
{
    use Uuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'investment_distribution';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'investment_distribution_id';

    protected function roundingReminder(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => new DistributionRoundingReminder($value),
        );
    }
}
