<?php

namespace App\Models\Mikapi;

use App\Models\Router;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Odp extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'id'        => 'integer',
        'user_id'   => 'integer',
        'router_id' => 'integer',
        'max_port'  => 'integer',
    ];

    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['user_id'])) {
            $query->where('user_id',  $filters['user_id']);
        }
        if (isset($filters['router_id'])) {
            $query->where('router_id',  $filters['router_id']);
        }
        if (isset($filters['router'])) {
            $query->where('router_id',  $filters['router']);
        }
        if (isset($filters['name'])) {
            $query->where('name', 'like',  '%' . $filters['name'] . '%');
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function router()
    {
        return $this->belongsTo(Router::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}
