<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $nameArray = explode(' ', $this->name);

        return [
            'id' => (int) $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'nickname' => $nameArray[0],
        ];
    }
}
