<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MeterReadingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => (int) $this->id,
            'tenancy_id' => (int) $this->id,
            'previous_units' => number_format($this->previous_units, 2),
            'current_units' => $this->current_units,
            'consumed_units' => $this->consumed_units,
            'bill' => json_decode($this->bill),
            'bill_delivery_id' => $this->bill_delivery_id,
            'bill_description' => $this->bill_description,
            'bill_delivery_status' => $this->bill_delivery_status,
            'created_at' => $this->created_at->toFormattedDateString(),

            'tenant' => $this->tenancy->tenant,
            'house' => $this->tenancy->house,
        ];
    }
}
