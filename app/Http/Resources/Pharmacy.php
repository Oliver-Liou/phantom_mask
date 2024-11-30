<?php

namespace App\Http\Resources;

use App\Models\PharmacyOpeningHour;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Pharmacy extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'cashBalance' => $this->cash_balance,
            'openingHours' => PharmacyOpeningHour::formatOpeningHours(new PharmacyOpeningHourCollection($this->openingHours)),
            'masks' => new MaskCollection($this->masks),
        ];
    }
}
