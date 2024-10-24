<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                    => $this->id,
            'DT_RowId'              => $this->id,
            'name'                  => $this->name,
            'email'                 => $this->email,
            'gender'                => $this->gender,
            'address'               => $this->address,
            'phone'                 => $this->phone,
            'email_verified_at'     => $this->email_verified_at,
            'balance'               => $this->balance,
            'router_limit'          => $this->router_limit,
            'last_login_at'         => $this->last_login_at,
            'last_login_ip'         => $this->last_login_ip,
            'avatar'                => $this->avatar,
            'role'                  => $this->role,
            'status'                => $this->status,
            'instagram'             => $this->instagram,
            'facebook'              => $this->facebook,
            'linkedin'              => $this->linkedin,
            'github'                => $this->github,
            'is_verified'           => $this->is_verified(),
            'is_complete'           => $this->is_complete(),
            'is_admin'              => $this->is_admin(),
            'is_active'             => $this->is_active(),
            'created_at'            => $this->created_at,
            'updated_at'            => $this->updated_at,
        ];
    }
}
