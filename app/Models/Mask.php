<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mask extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pharmacy_id',
        'name',
        'price',
    ];

    /**
     * Scope a query to include mask by name.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $name name of mask
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

    /**
     * Scope a query to include mask by pharmacy_id.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $pharmacy_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchPharmacy($query, $pharmacy_id)
    {
        if (is_null($pharmacy_id)){
            return $query;
        } else {
            return $query->where('pharmacy_id', $pharmacy_id);
        }
    }

    /**
     * Scope a query to sort mask by name_sort.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $name_sort
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSortName($query, $name_sort)
    {
        if (!in_array($name_sort, ['DESC', 'ASC'])){
            return $query;
        } else {
            return $query->orderBy('name', $name_sort);
        }
    }


    /**
     * Scope a query to sort mask by price_sort.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $price_sort
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSortPrice($query, $price_sort)
    {
        if (!in_array($price_sort, ['DESC', 'ASC'])){
            return $query;
        } else {
            return $query->orderBy('price', $price_sort);
        }
    }
}
