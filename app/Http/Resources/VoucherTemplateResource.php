<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VoucherTemplateResource extends JsonResource
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
            'id'                => $this->id,
            'DT_RowId'          => $this->id,
            'name'              => $this->name,
            'html_vc'           => $this->html_vc,
            'html_up'           => $this->html_up,
            'header'            => $this->header,
            'footer'            => $this->footer,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
            'html_vc_sample'    => $this->sample_vc(),
            'html_up_sample'    => $this->sample_up(),
        ];
    }
}
