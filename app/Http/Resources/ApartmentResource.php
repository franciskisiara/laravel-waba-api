<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApartmentResource extends JsonResource
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
            'name' => $this->name,
            'caretaker_id' => $this->caretaker_id,
            'flat_rate_limit' => $this->flat_rate_limit,
            'flat_rate' => $this->flat_rate,
            'unit_rate' => $this->unit_rate,
        ];
    }
}
