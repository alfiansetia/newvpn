<?php

namespace App\Http\Resources\Mikapi;

use App\Http\Resources\RouterResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OdpResource extends JsonResource
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
            'id'                => $this->id,
            'DT_RowId'          => $this->id,
            'user_id'           => $this->user_id,
            'router_id'         => $this->router_id,
            'name'              => $this->name,
            'max_port'          => $this->max_port,
            'lat'               => $this->lat,
            'long'              => $this->long,
            'desc'              => $this->desc,
            'line_color'        => $this->line_color,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
            'valid_location'    => valid_latlong($this->lat, $this->long),
            'valid_location'    => valid_latlong($this->lat, $this->long),
            'user'              => new UserResource($this->whenLoaded('user')),
            'router'            => new RouterResource($this->whenLoaded('router')),
            'customers'         => CustomerResource::collection($this->whenLoaded('customers')),
            'customers_count'   => $this->customers_count ?? 0,
        ];
    }
}
