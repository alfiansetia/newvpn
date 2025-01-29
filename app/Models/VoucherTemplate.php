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

    public $qr = "data:image/png;base64,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";

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
            'src="' . $this->qr . '"',
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
