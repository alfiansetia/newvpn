<?php

namespace App\Http\Resources\Mikapi;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QueueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'DT_RowId'  => $this['.id'] ?? 0,
            '.id'       => $this['.id'] ?? 0,
            'name'      => $this['name'],
            // 'topics'    => $this['topics'],
            // 'message'   => $this['message'],
        ];
    }
}
