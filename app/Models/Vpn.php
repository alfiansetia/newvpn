<?php

namespace App\Models;

use App\Services\ServerServices;
use App\Services\VpnServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Vpn extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'id'            => 'integer',
        'user_id'       => 'integer',
        'server_id'     => 'integer',
        'is_active'     => 'boolean',
        'is_trial'      => 'boolean',
        'auto_renew'    => 'boolean',
    ];

    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['username'])) {
            $query->where('username', 'like', '%' . $filters['username'] . '%');
        }
        if (isset($filters['ip'])) {
            $query->where('ip', 'like', '%' . $filters['ip'] . '%');
        }
        if (isset($filters['vpns.user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }
        if (isset($filters['server_id'])) {
            $query->where('vpns.server_id', $filters['server_id']);
        }
        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }
        if (isset($filters['is_trial'])) {
            $query->where('is_trial', $filters['is_trial']);
        }
        if (isset($filters['dst'])) {
            $query->whereRelation('ports', 'dst', $filters['dst']);
        }
        if (isset($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function server()
    {
        return $this->belongsTo(Server::class);
    }

    public function ports()
    {
        return $this->hasMany((Port::class));
    }

    public function is_expired()
    {
        if ($this->expired) {
            $expiredDate = Carbon::createFromFormat('Y-m-d', $this->expired);
            $today = Carbon::now();
            if ($expiredDate->lessThanOrEqualTo($today)) {
                return true;
            }
        }
        return false;
    }

    public function origin()
    {
        $service = new VpnServices();
        try {
            $detail = $service->server($this->server)->show($this);
        } catch (\Throwable $th) {
            $detail = null;
        }
        try {
            $active = $service->server($this->server)->active($this);
        } catch (\Throwable $th) {
            $active = null;
        }

        return [
            'detail' => $detail,
            'active' => $active,
        ];
    }
}
