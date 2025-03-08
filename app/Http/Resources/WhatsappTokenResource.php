<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WhatsappTokenResource extends JsonResource
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
            'id'            => $this->id,
            'DT_RowId'      => $this->id,
            'user_id'       => $this->user_id,
            'value'         => $this->value,
            'from'          => $this->from,
            'desc'          => $this->desc,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
            'user'          => new UserResource($this->whenLoaded('user')),
        ];
    }
}
