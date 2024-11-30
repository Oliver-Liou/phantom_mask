<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'cash_balance',
    ];

    public function masks()
    {
        return $this->hasMany(Mask::class);
    }

    public function openingHours()
    {
        return $this->hasMany(PharmacyOpeningHour::class);
    }

    /**
     * Scope a query to include pharmacy by opening time or day_of_week.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $time
     * @param string $day_of_week
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchOpening($query, $time, $day_of_week)
    {
        $query->whereHas('openingHours', function ($query) use ($time, $day_of_week) {
            if (!is_null($time)) {
                $query = $query->where('open_time', '<', $time)
                    ->where('close_time', '>', $time);
            }
            if (!is_null($day_of_week)) {
                $query = $query->whereJsonContains('day_of_week', $day_of_week);
            }
            return $query;
        });
    }

    /**
     * Scope a query to include pharmacy by priceRange and count more or less.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $count
     * @param string $condition
     * @param array $priceRange
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchMaskPriceRangeAndCount($query, $count, $condition, $priceRange)
    {
        if(empty($count) || empty($condition) || empty($priceRange[0]) || empty($priceRange[1])) return $query;

        return $query->whereHas('masks', function ($query) use ($priceRange) {
            $query->whereBetween('price', $priceRange);
        })->withCount(['masks' => function ($query) use ($priceRange) {
            $query->whereBetween('price', $priceRange);
        }])->when($condition === 'more', function ($query) use ($count) {
            $query->having('masks_count', '>', $count);
        })->when($condition === 'less', function ($query) use ($count) {
            $query->having('masks_count', '<', $count);
        });
    }

    /**
     * Scope a query to include pharmacy by name.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $name
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchName($query, $name)
    {
        if (is_null($name)){
            return $query;
        } else {
            return $query->where('name', 'like', "%$name%");
        }
    }
}
