<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherTemplate extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }
    }

    public $qr = "";

    public function qr()
    {
        return base64_encode(public_path('images/default/qr.png'));
    }

    public $replace = [
        '%_USER_%',
        '%_PASSWORD_%',
        '%_PRICE_%',
        '%_VALIDITY_%',
        '%_LIMIT_UPTIME_%',
        '%_LIMIT_QUOTA_%',
        '%_QR_%',
        '%_ROUTER_LOGO_%',
        '%_ROUTER_DNS_%',
        '%_ROUTER_CONTACT_%',
        '%_NUMBER_%',
        '%_PROFILE_%',
        '%_ROUTER_NAME_%',
    ];

    public function get_sample()
    {
        return [
            'KCNET',
            'KCNPASS',
            '10.000',
            '1 Hari',
            '1 Hari',
            '3 GiB',
            'src="' . $this->qr() . '"',
            url('/images/default/logo.svg'),
            'http://wifi.net',
            '082324129752',
            1,
            '7 Hari',
            'KCN WIFI'
        ];
    }

    public function sample_up()
    {
        return $this->generate_up($this->get_sample());
    }

    public function sample_vc()
    {
        return $this->generate_vc($this->get_sample());
    }

    public function generate_vc(array $data)
    {
        $html_vc = $this->html_vc;
        $html_vc_sample = str_replace($this->replace, $data, $html_vc);
        return $html_vc_sample;
    }

    public function generate_up(array $data)
    {
        $html_up = $this->html_up;
        $html_up_sample = str_replace($this->replace, $data, $html_up);
        return $html_up_sample;
    }
}
