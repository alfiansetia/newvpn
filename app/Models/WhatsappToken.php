<?php

namespace App\Models;

use App\Services\Whatsapp\FonnteServices;
use Illuminate\Database\Eloquent\Model;

class WhatsappToken extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'id'            => 'integer',
        'user_id'       => 'integer',
    ];

    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }
        if (isset($filters['from'])) {
            $query->where('from', $filters['from']);
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detail()
    {
        return FonnteServices::detail_device($this->value);
    }
}
