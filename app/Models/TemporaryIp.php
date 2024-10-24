<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryIp extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'id'        => 'integer',
        'server_id' => 'integer',
    ];

    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['ip'])) {
            $query->where('ip', 'like', '%' . $filters['ip'] . '%');
        }
        if (isset($filters['server_id'])) {
            $query->where('server_id', $filters['server_id']);
        }
    }

    public function server()
    {
        return $this->belongsTo(Server::class);
    }
}
