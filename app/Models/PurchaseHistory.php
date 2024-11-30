<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseHistory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'pharmacy_id',
        'mask_id',
        'pharmacy_name',
        'mask_name',
        'transaction_amount',
        'transaction_date',
    ];


    /**
     * Scope a query to include purchase histories by dayRange.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $dayRange
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchDateRange($query, $dayRange)
    {
        if (is_null($dayRange[0]) || is_null($dayRange[1]))  return $query;

        return $query->whereBetween('transaction_date', $dayRange);
    }

    public function getMaskQuantityPerPackAttribute()
    {
        preg_match('/(\d+)\s+per\s+pack/i', $this->mask_name, $matches);
        return isset($matches[1]) ? (int) $matches[1] : 1; // 默認每包數量為 1
    }
}
