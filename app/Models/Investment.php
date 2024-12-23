<?php

namespace App\Models;

use App\Models\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $investment_id
 * @property int $amount
 * @property string $created_at
 * @property string $updated_at
 *
 * @property InvestmentDistribution[] $distributions
 */
class Investment extends Model
{
    use Uuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'investments';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'investment_id';

    public function distributions(): HasMany
    {
        return $this->hasMany(InvestmentDistribution::class, 'investment_id', 'investment_id');
    }
}
