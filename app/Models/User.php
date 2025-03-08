<?php

namespace App\Models;

use App\Notifications\NewLoginNotification;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'balance',
        'router_limit',
        'phone',
        'address',
        'role',
        'avatar',
        'last_login_at',
        'last_login_ip',
        'email_verified_at',
        'status',
        'gender',
        'instagram',
        'facebook',
        'linkedin',
        'github'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id'                => 'integer',
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'balance'           => 'integer',
            'is_verified'       => 'boolean',
            'is_complete'       => 'boolean',
            'is_admin'          => 'boolean',
            'is_active'         => 'boolean',
            'router_limit'      => 'integer',
        ];
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function sendEmailNewLogin($ip, $userAgent)
    {
        $this->notify(new NewLoginNotification($ip, $userAgent));
    }

    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }
        if (isset($filters['email'])) {
            $query->where('email', 'like', '%' . $filters['email'] . '%');
        }
    }


    public function vpn()
    {
        return $this->hasMany(Vpn::class);
    }

    public function getAvatarAttribute($value)
    {
        if ($value && file_exists(public_path('/images/avatar/' . $value))) {
            return url('/images/avatar/' . $value);
        } else {
            return url('/images/default/avatar-' . $this->gender . '.png');
        }
    }

    public function is_verified()
    {
        return $this->email_verified_at != null;
    }

    public function is_complete()
    {
        if (
            empty($this->address) || empty($this->phone) || empty($this->phone) || empty($this->instagram)
            || empty($this->facebook) || empty($this->linkedin) || empty($this->github)
        ) {
            return true;
        } else {
            return false;
        }
    }

    public function is_admin()
    {
        return $this->role == 'admin';
    }

    public function is_active()
    {
        return $this->status == 'active';
    }

    public function is_not_admin()
    {
        return $this->role != 'admin';
    }

    public function notifications()
    {
        return $this->hasMany(NotificationUser::class);
    }

    public function notification_unreads()
    {
        return $this->hasMany(NotificationUser::class)->where('is_read', 'no');
    }

    public function min_balance($amount, $desc = '')
    {
        $user_balance = $this->balance;
        $new_user_balance_min = $user_balance - $amount;
        $this->update([
            'balance' => $new_user_balance_min,
        ]);
        BalanceHistory::create([
            'date'      => date('Y-m-d H:i:s'),
            'user_id'   => $this->id,
            'amount'    => $amount,
            'type'      => 'min',
            'before'    => $user_balance,
            'after'     => $new_user_balance_min,
            'desc'      => $desc,
        ]);
        return true;
    }

    public function plus_balance($amount, $desc = '')
    {
        $user_balance = $this->balance;
        $new_user_balance_plus = $user_balance + $amount;
        $this->update([
            'balance' => $new_user_balance_plus,
        ]);
        BalanceHistory::create([
            'date'      => date('Y-m-d H:i:s'),
            'user_id'   => $this->id,
            'amount'    => $amount,
            'type'      => 'plus',
            'before'    => $user_balance,
            'after'     => $new_user_balance_plus,
            'desc'      => $desc,
        ]);
        return true;
    }

    public function wa_tokens()
    {
        return $this->hasMany(WhatsappToken::class);
    }
}
