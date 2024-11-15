<?php

namespace App\Http\Resources\Mikapi\System;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScriptResource extends JsonResource
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
            'DT_RowId'                  => $this['.id'] ?? 0,
            '.id'                       => $this['.id'] ?? 0,
            'comment'                   => $this['comment'] ?? null,
            'dont-require-permissions'  => ($this['dont-require-permissions'] ?? false) == "true" ? true : false,
            'invalid'                   => ($this['invalid'] ?? false) == "true" ? true : false,
            'last-started'              => $this['last-started'] ?? null,
            'name'                      => $this['name'] ?? null,
            'owner'                     => $this['owner'] ?? null,
            'policy'                    => $this['policy'] ?? null,
            'run-count'                 => (int) ($this['run-count'] ?? '0'),
            'source'                    => $this['source'] ?? null,
        ];
    }
}
