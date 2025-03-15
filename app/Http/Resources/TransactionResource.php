<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'id'        => $this->id,
            'DT_RowId'  => $this->id,
            'date'      => $this->date,
            'amount'    => $this->amount,
            'type'      => $this->type,
            'desc'      => $this->desc,
        ];
    }
}
