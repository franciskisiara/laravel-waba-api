<?php

namespace App\Http\Resources;

use App\Models\Tenancy;
use Illuminate\Http\Resources\Json\JsonResource;

class HouseResource extends JsonResource
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
            'tenant_id' => $this->tenant_id,
            'house_number' => $this->house_number,
            'tenant' => new UserResource($this->whenLoaded('tenant')),
            'tenancy' => Tenancy::where('house_id', $this->id)
                ->where('tenant_id', $this->tenant_id)
                ->latest()
                ->first(),
        ];
    }
}
