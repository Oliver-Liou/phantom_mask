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
}
