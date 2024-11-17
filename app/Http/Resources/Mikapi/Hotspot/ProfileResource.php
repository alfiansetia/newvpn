<?php

namespace App\Http\Resources\Mikapi\Hotspot;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'DT_RowId'              => $this['.id'] ?? 0,
            '.id'                   => $this['.id'] ?? 0,
            'add-mac-cookie'        => ($this['add-mac-cookie'] ?? false) == "true" ? true : false,
            'address-list'          => $this['address-list'] ?? null,
            'advertise'             => ($this['advertise'] ?? false) == "true" ? true : false,
            'advertise-interval'    => $this['advertise-interval'] ?? null,
            'advertise-timeout'     => $this['advertise-timeout'] ?? null,
            'advertise-url'         => $this['advertise-url'] ?? null,
            'default'               => ($this['default'] ?? false) == "true" ? true : false,
            'idle-timeout'          => $this['idle-timeout'] ?? null,
            'incoming-filter'       => $this['incoming-filter'] ?? null,
            'incoming-packet-mark'  => $this['incoming-packet-mark'] ?? null,
            'insert-queue-before'   => $this['insert-queue-before'] ?? null,
            'keepalive-timeout'     => $this['keepalive-timeout'] ?? null,
            'mac-cookie-timeout'    => $this['mac-cookie-timeout'] ?? null,
            'name'                  => $this['name'] ?? null,
            'on-login'              => $this['on-login'] ?? null,
            'on-logout'             => $this['on-logout'] ?? null,
            'open-status-page'      => $this['open-status-page'] ?? null,
            'outgoing-filter'       => $this['outgoing-filter'] ?? null,
            'outgoing-packet-mark'  => $this['outgoing-packet-mark'] ?? null,
            'parent-queue'          => $this['parent-queue'] ?? null,
            'queue-type'            => $this['queue-type'] ?? null,
            'rate-limit'            => $this['rate-limit'] ?? null,
            'session-timeout'       => $this['session-timeout'] ?? null,
            'shared-users'          => $this['shared-users'] == 'unlimited' ? 0 : $this['shared-users'],
            'status-autorefresh'    => $this['status-autorefresh'] ?? null,
            'transparent-proxy'     => ($this['transparent-proxy'] ?? false) == "true" ? true : false,
            'session_timeout_parse_array'     =>  dtm_new_array($this['session-timeout'] ?? ''),
            'scheduler'             => $this['scheduler'] ?? false,
            'mikhmon'               => $this['mikhmon'] ?? null,
        ];
    }
}
