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
        $tenant = $this->tenancy->tenant;
        $house = $this->tenancy->house;

        return [
            'id' => (int) $this->id,
            'tenancy_id' => (int) $this->id,
            'previous_units' => number_format($this->previous_units, 2),
            'current_units' => $this->current_units,
            'consumed_units' => $this->consumed_units,
            'bill' => json_decode($this->bill),
            'communication_status' => $this->communication_status,
            'occupancy' => "$tenant->name - $house->house_number",
        ];
    }
}
