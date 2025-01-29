<?php

namespace App\Http\Resources\Mikapi;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $date = null;
        $time = null;
        $username = null;
        $ip = null;
        $mac = null;
        $validity = null;
        $price = 0;
        $profile = null;
        $comment = null;
        $explode =  explode("-|-", $this['name'] ?? '');
        if (count($explode) > 7) {
            $date =  $explode[0];
            $time =  $explode[1];
            $username =  $explode[2];
            $price =  (int) ($explode[3] ?? '0');
            $ip =  $explode[4];
            $mac =  $explode[5];
            $validity =  $explode[6];
            $profile =  $explode[7];
            $comment =  $explode[8];
        }
        return [
            'DT_RowId'      => $this['.id'] ?? 0,
            '.id'           => $this['.id'] ?? 0,
            'explode'       => $explode,
            'date'          => $date,
            'time'          => $time,
            'username'      => $username,
            'ip'            => $ip,
            'mac'           => $mac,
            'validity'      => $validity,
            'price'         => $price,
            'profile'       => $profile,
            'comment'       => $comment,
        ];
    }
}
