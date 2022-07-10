<?php

namespace App\Http\Resources;

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
        $activeTenancyId = optional(
            $this->tenancies()
                ->whereNull('deleted_at')
                ->orderBy('id', 'desc')
                ->first()
        )->id;

        return [
            'id' => (int) $this->id,
            'house_number' => $this->house_number,
            'active_tenancy_id' => $activeTenancyId,
            'tenant' => new UserResource($this->tenant),
        ];
    }
}
