<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Port extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'id'        => 'integer',
        'vpn_id'    => 'integer',
        'dst'       => 'integer',
        'to'        => 'integer',
    ];

    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['vpn_id'])) {
            $query->where('vpn_id', $filters['vpn_id']);
        }
        if (isset($filters['dst'])) {
            $query->where('dst', $filters['dst']);
        }
        if (isset($filters['to'])) {
            $query->where('to', $filters['to']);
        }
        if (isset($filters['username'])) {
            $query->whereRelation('vpn', 'username', 'like', "%" . $filters['username'] . "%");
        }
        if (isset($filters['user_id'])) {
            $query->whereRelation('vpn', 'user_id', $filters['user_id']);
        }
    }

    public function vpn()
    {
        return $this->belongsTo(Vpn::class);
    }
}
