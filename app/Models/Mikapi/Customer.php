<?php

namespace App\Models\Mikapi;

use App\Models\Router;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'id'            => 'integer',
        'user_id'       => 'integer',
        'package_id'    => 'integer',
        'odp_id'        => 'integer',
        'due'           => 'integer',
    ];

    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['user_id'])) {
            $query->where('user_id',  $filters['user_id']);
        }
        if (isset($filters['package_id'])) {
            $query->where('package_id',  $filters['package_id']);
        }
        if (isset($filters['odp_id'])) {
            $query->where('odp_id',  $filters['odp_id']);
        }
        if (isset($filters['router_id'])) {
            $query->whereRelation('package.router', 'id',  $filters['router_id']);
        }
        if (isset($filters['name'])) {
            $query->where('name', 'like',  '%' . $filters['name'] . '%');
        }
        if (isset($filters['number_id'])) {
            $query->where('number_id',  $filters['number_id']);
        }
        if (isset($filters['phone'])) {
            $query->where('phone',  $filters['phone']);
        }
        if (isset($filters['email'])) {
            $query->where('email',  $filters['email']);
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function odp()
    {
        return $this->belongsTo(Odp::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
