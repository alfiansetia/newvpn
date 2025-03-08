<?php

namespace App\Models;

use App\Mail\DetailTopupMail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Topup extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['desc'])) {
            $query->where('desc', 'like', '%' . $filters['desc'] . '%');
        }
        if (isset($filters['number'])) {
            $query->where('number', 'like', '%' . $filters['number'] . '%');
        }
        if (isset($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }
        if (isset($filters['bank_id'])) {
            $query->where('bank_id', $filters['bank_id']);
        }
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function send_notif()
    {
        Mail::to($this->user->email)->queue(new DetailTopupMail($this));
        return true;
    }

    public function getImageAttribute($value)
    {
        if ($value && file_exists(storage_path('app/images/invoice/' . $value))) {
            return storage_path('app/images/invoice/' . $value);
        } else {
            return url('images/default/invoice.png');
        }
    }
}
