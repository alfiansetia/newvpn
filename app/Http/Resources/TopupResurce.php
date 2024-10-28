<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TopupResurce extends JsonResource
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
            'date'          => $this->date,
            'number'        => $this->number,
            'amount'        => $this->amount,
            'status'        => $this->status,
            'image'         => $this->image,
            'desc'          => $this->desc,
            'user_id'       => $this->user_id,
            'bank_id'       => $this->bank_id,
            'user'          => new UserResource($this->whenLoaded('user')),
            'bank'          => new BankResource($this->whenLoaded('bank')),
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
        ];
    }
}
