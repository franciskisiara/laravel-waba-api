<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TenancyResource extends JsonResource
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
            'house_id'=> (int) $this->house_id,
            'tenant_id' => (int) $this->tenant_id,
            'running_balance' => $this->running_balance,
            'house' => new HouseResource($this->whenLoaded(('house'))),
            'tenant' => new UserResource($this->whenLoaded(('tenant'))),
        ];
    }
}
