<?php

namespace App\Http\Resources\Mikapi;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'package_id'        => $this->package_id,
            'odp_id'            => $this->odp_id,
            'name'              => $this->name,
            'number_id'         => $this->number_id,
            'phone'             => $this->phone,
            'email'             => $this->email,
            'identity'          => $this->identity,
            'address'           => $this->address,
            'regist'            => $this->regist,
            'due'               => $this->due,
            'ip'                => $this->ip,
            'mac'               => $this->mac,
            'number_id'         => $this->number_id,
            'lat'               => $this->lat,
            'long'              => $this->long,
            'type'              => $this->type,
            'secret_username'   => $this->secret_username,
            'secret_password'   => $this->secret_password,
            'status'            => $this->status,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
            'valid_location'    => valid_latlong($this->lat, $this->long),
            'user'              => new UserResource($this->whenLoaded('user')),
            'package'           => new PackageResource($this->whenLoaded('package')),
            'odp'               => new OdpResource($this->whenLoaded('odp')),
            'router_active'     => $this->router_active ??  false,
            'router_uptime'     => dtm_new($this->router_uptime ?? '0s'),
        ];
    }
}
