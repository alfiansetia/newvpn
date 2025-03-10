<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class Router extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'id'        => 'integer',
        'user_id'   => 'integer',
        'port_id'   => 'integer',
    ];

    protected $hidden = [
        'password',
    ];

    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }
        if (isset($filters['hsname'])) {
            $query->where('hsname', 'like', '%' . $filters['hsname'] . '%');
        }
        if (isset($filters['dnsname'])) {
            $query->where('dnsname', 'like', '%' . $filters['dnsname'] . '%');
        }
        if (isset($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }
        if (isset($filters['port_id'])) {
            $query->where('port_id', $filters['port_id']);
        }
    }

    public function port()
    {
        return $this->belongsTo(Port::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getUrlLogoAttribute($value)
    {
        if (!$value) {
            return asset('images/default/logo.svg');
        } else {
            return $value;
        }
    }

    public function destroy_cache()
    {
        // $path = storage_path('app/mikapi/hotspot/user');
        // $file = $path . '/' . $this->id . '.json';
        // if (file_exists($file)) {
        //     File::delete($file);
        // }
        Cache::forget('router_cache_' . $this->id);
    }

    public function destroy_cache_by_ids(array $ids)
    {
        // $path = storage_path('app/mikapi/hotspot/user');
        // foreach ($ids as $item) {
        //     $file = $path . '/' . $item . '.json';
        //     if (file_exists($file)) {
        //         File::delete($file);
        //     }
        // }
        foreach ($ids as $item) {
            Cache::forget('router_cache_' . $item);
        }
    }
}
