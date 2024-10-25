<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalanceHistory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'id'        => 'integer',
        'user_id'   => 'integer',
        'amount'    => 'integer',
        'before'    => 'integer',
        'after'     => 'integer',
    ];

    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['user_id'])) {
            $query->where('user_id',  $filters['user_id']);
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
