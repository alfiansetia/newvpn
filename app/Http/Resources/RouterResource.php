<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RouterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'hsname'        => $this->hsname,
            'dnsname'       => $this->dnsname,
            'contact'       => $this->contact,
            'url_logo'      => $this->url_logo,
            'port_id'       => $this->port_id,
            'user_id'       => $this->user_id,
            'user'          => new UserResource($this->whenLoaded('user')),
            'port'          => new PortResource($this->whenLoaded('port')),
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
        ];
    }
}
