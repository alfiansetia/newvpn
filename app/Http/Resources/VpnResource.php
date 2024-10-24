<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VpnResource extends JsonResource
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
            'user_id'       => $this->user_id,
            'server_id'     => $this->server_id,
            'ip'            => $this->ip,
            'username'      => $this->username,
            'password'      => $this->password,
            'auto_renew'    => $this->auto_renew,
            'last_renew'    => $this->last_renew,
            'expired'       => $this->expired,
            'is_active'     => $this->is_active,
            'is_trial'      => $this->is_trial,
            'desc'          => $this->desc,
            'last_send_notification'    => $this->last_send_notification,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
            'port_count'    => $this->whenCounted('ports'),
            'user'          => new UserResource($this->whenLoaded('user')),
            'server'        => new ServerResource($this->whenLoaded('server')),
            'ports'         => PortResource::collection($this->whenLoaded('ports')),
        ];
    }
}
