<?php

namespace App\Http\Resources\Mikapi;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PoolResource extends JsonResource
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
            'DT_RowId'  => $this['.id'] ?? 0,
            '.id'       => $this['.id'] ?? 0,
            'name'      => $this['name'] ?? '',
            'comment'   => $this['comment'] ?? '',
            'next-pool' => $this['next-pool'] ?? 'none',
            'ranges'    => $this['ranges'] ?? '0.0.0.0',
        ];
    }
}
