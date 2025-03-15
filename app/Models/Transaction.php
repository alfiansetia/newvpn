<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'id'            => 'integer',
        'amount'        => 'integer',
    ];

    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['date'])) {
            $query->where('date', $filters['date']);
        }
        if (isset($filters['type'])) {
            $query->where('type', $filters['type']);
        }
    }
}
