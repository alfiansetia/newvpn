<?php

namespace App\Http\Resources\Mikapi;

use App\Http\Resources\RouterResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id'            => $this->id,
            'DT_RowId'      => $this->id,
            'user_id'       => $this->user_id,
            'router_id'     => $this->router_id,
            'name'          => $this->name,
            'speed_up'      => $this->speed_up,
            'speed_down'    => $this->speed_down,
            'price'         => $this->price,
            'ppn'           => $this->ppn,
            'profile'       => $this->profile,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
            'user'          => new UserResource($this->whenLoaded('user')),
            'router'        => new RouterResource($this->whenLoaded('router')),
            'customers'         => CustomerResource::collection($this->whenLoaded('customers')),
            'customers_count'   => $this->customers_count ?? 0,
        ];
    }
}
