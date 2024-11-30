<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseHistory extends JsonResource
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
            'pharmacyName' => $this->pharmacy_name,
            'maskName' => $this->mask_name,
            'transactionAmount' => $this->transaction_amount,
            'transactionDate' => $this->transaction_date,
        ];
    }
}
