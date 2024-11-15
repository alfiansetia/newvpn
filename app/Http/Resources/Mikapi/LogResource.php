<?php

namespace App\Http\Resources\Mikapi;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        $mesage = $this['message'] ?? null;
        $ip = null;
        $mesage_parse = null;
        if (
            preg_match('/->:\s*([^:]+):\s*(.+)/', $mesage, $matches) ||
            preg_match('/^([^:]+):\s*(.+)/', $mesage, $matches)
        ) {

            $identifier = trim($matches[1]);
            $remainingMessage = trim($matches[2]);

            $ip = $identifier;
            $mesage_parse = $remainingMessage;
        }
        return [
            'DT_RowId'  => $this['.id'] ?? 0,
            '.id'       => $this['.id'] ?? 0,
            'time'      => date_log($this['time']),
            'topics'    => $this['topics'] ?? null,
            'message'   => $mesage,
            'ip'        => $ip,
            'message_parse' => $mesage_parse,
        ];
    }
}
