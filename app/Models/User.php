<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'cash_balance',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    public function purchaseHistories()
    {
        return $this->hasMany(PurchaseHistory::class);
    }

    /**
     * Scope a query to include users by purchaseHistories rank in dayRange.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $rank
     * @param array $dayRange
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchTransactionRank($query, $rank, $dayRange)
    {
        if (is_null($rank) || is_null($dayRange[0]) || is_null($dayRange[1]))  return $query;

        return $query->whereHas('purchaseHistories', function ($query) use ($rank, $dayRange) {
            $query->whereBetween('transaction_date', $dayRange);
        })->withSum(['purchaseHistories as total_transaction_amount' => function ($query) use ($dayRange) {
            $query->whereBetween('transaction_date', $dayRange);
        }], 'transaction_amount')
            ->orderBy('total_transaction_amount', 'desc')
            ->take($rank);
    }
}
