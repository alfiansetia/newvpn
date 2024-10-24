<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PortResource extends JsonResource
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
            'DT_RowId'      => $this->id,
            'dst'           => $this->dst,
            'to'            => $this->to,
            'vpn_id'        => $this->vpn_id,
            'vpn'           => new VpnResource($this->whenLoaded('vpn')),
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
            // 'vpn_username'  => $this->whenLoaded('vpn', function () {
            //     return $this->vpn->username;
            // }),
        ];
    }
}
