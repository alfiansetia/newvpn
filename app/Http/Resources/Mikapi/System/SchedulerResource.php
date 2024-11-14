<?php

namespace App\Http\Resources\Mikapi\System;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SchedulerResource extends JsonResource
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
            'DT_RowId'          => $this['.id'],
            '.id'               => $this['.id'],
            'comment'           => $this['comment'] ?? null,
            'interval'          => $this['interval'] ?? null,
            'disabled'          => ($this['disabled'] ?? false) == "true" ? true : false,
            'name'              => $this['name'] ?? null,
            'next-run'          => $this['next-run'] ?? null,
            'on-event'          => $this['on-event'] ?? null,
            'owner'             => $this['owner'] ?? null,
            'policy'            => $this['policy'] ?? null,
            'run-count'         => (int) ($this['run-count'] ?? '0'),
            'start-date'        => $this['start-date'] ?? null,
            'start-time'        => $this['start-time'] ?? null,
        ];
    }
}
