<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        static $key = 0;
        $key++;
        return [
            'id'            => $key,
            'DT_RowId'      => $key,
            'name'          => basename($this->resource),
            'size'          => filesize($this->resource),
            'modified_at'   => filemtime($this->resource),
        ];
    }
}
