<?php

namespace App\Services\Mikapi\Hotspot;

use App\Services\RouterApiServices;
use App\Traits\CrudApiTrait;
use Exception;
use Illuminate\Http\Request;

class ProfileServices extends RouterApiServices
{
    use CrudApiTrait;

    public function __construct()
    {
        parent::__construct();

        parent::$name = 'hotspot';
        parent::$command = '/ip/hotspot/user/profile/';
        parent::$cache = false;
    }

    public static function get(array $filters = [])
    {
        $new_filters = [];
        foreach ($filters as $key => $value) {
            if (!empty($value)) {
                $new_filters["?$key"] = $value;
            }
        }
        $schedulers = parent::$API->comm('/system/scheduler/print');
        parent::cek_error($schedulers);
        $data = parent::$API->comm(parent::$command . "print", $new_filters);
        parent::cek_error($data);
        $data = array_map(function ($item) use ($schedulers) {
            $item['scheduler'] = false;
            foreach ($schedulers as $scheduler) {
                if (!isset($scheduler['name']) || !isset($scheduler['disabled'])) {
                    break;
                }
                if ($scheduler['name'] === $item['name'] && $scheduler['disabled'] == 'false') {
                    $item['scheduler'] = true;
                    break;
                }
            }
            return $item;
        }, $data);
        if (parent::$cache) {
            $cache = static::to_cache($data);
        }
        return $data;
    }

    public static function show(string $id)
    {
        $data = parent::$API->comm(parent::$command . "print", [
            '?.id' => $id
        ]);
        parent::cek_error($data);
        if (empty($data)) {
            throw new Exception('Data Not Found!');
        }
        $newdata = $data[0];
        $scheduler = parent::$API->comm('/system/scheduler/print', [
            "?name" => $newdata['name'],
        ]);
        if (!isset($scheduler[0]['name']) || !isset($scheduler[0]['disabled'])) {
            $newdata['scheduler'] = false;
        } else {
            if ($scheduler[0]['name'] === $newdata['name'] && $scheduler[0]['disabled'] == 'false') {
                $newdata['scheduler'] = true;
            }
        }
        return $newdata;
    }

    public static function store(Request $request)
    {

        $param = static::store_mikhmon($request);
        $id = parent::$API->comm(parent::$command . "add", $param);
        parent::cek_error($id);
        if (parent::$cache) {
            $data = static::show($id);
            $cache = static::store_item_to_cache($data);
        }
        return $id;
    }

    public static function store_mikhmon(Request $request)
    {
        $name = (preg_replace('/\s+/', '-', $request->input('name')));
        $expmode = $request->expired_mode;
        $lock_user = $request->lock_user;
        $randstarttime = "0" . rand(1, 5) . ":" . rand(10, 59) . ":" . rand(10, 59);
        $randinterval = "00:02:" . rand(10, 59);
        $mode = '';
        $price = $request->price;
        $selling_price = $request->selling_price;
        $day = $request->data_day;
        $time = parse_dtm_to_string($request->time_limit ?? '00:00:00');
        $validity = '';
        if ($day > 0) {
            $validity .= $day . 'd';
        }
        if (!empty($time)) {
            $validity .= $time;
        }
        if ($expmode != 0) {
        } else {
            $validity = '';
        }

        if ($lock_user == "Enable") {
            $lock_script = '; [:local mac $"mac-address"; /ip hotspot user set mac-address=$mac [find where name=$user]]';
        } else {
            $lock_script = "";
        }

        $record = '; :local mac $"mac-address"; :local time [/system clock get time ]; /system script add name="$date-|-$time-|-$user-|-' . $price . '-|-$address-|-$mac-|-' . $validity . '-|-' . $name . '-|-$comment" owner="$month$year" source="$date" comment="mikhmon"';

        $on_login = ':put (",' . $expmode . ',' . $price . ',' . $validity . ',' . $selling_price . ',,' . $lock_user . ',"); {:local comment [ /ip hotspot user get [/ip hotspot user find where name="$user"] comment]; :local ucode [:pic $comment 0 2]; :if ($ucode = "vc" or $ucode = "up" or $comment = "") do={ :local date [ /system clock get date ];:local year [ :pick $date 7 11 ];:local month [ :pick $date 0 3 ]; /sys sch add name="$user" disable=no start-date=$date interval="' . $validity . '"; :delay 5s; :local exp [ /sys sch get [ /sys sch find where name="$user" ] next-run]; :local getxp [len $exp]; :if ($getxp = 15) do={ :local d [:pic $exp 0 6]; :local t [:pic $exp 7 16]; :local s ("/"); :local exp ("$d$s$year $t"); /ip hotspot user set comment="$exp" [find where name="$user"];}; :if ($getxp = 8) do={ /ip hotspot user set comment="$date $exp" [find where name="$user"];}; :if ($getxp > 15) do={ /ip hotspot user set comment="$exp" [find where name="$user"];};:delay 5s; /sys sch remove [find where name="$user"]';
        if ($expmode == "rem") {
            $on_login = $on_login . $lock_script . "}}";
            $mode = "remove";
        } elseif ($expmode == "ntf") {
            $on_login = $on_login . $lock_script . "}}";
            $mode = "set limit-uptime=1s";
        } elseif ($expmode == "remc") {
            $on_login = $on_login . $record . $lock_script . "}}";
            $mode = "remove";
        } elseif ($expmode == "ntfc") {
            $on_login = $on_login . $record . $lock_script . "}}";
            $mode = "set limit-uptime=1s";
        } elseif ($expmode == "0" && $price > 0) {
            $on_login = ':put (",,' . $price . ',,,noexp,' . $lock_user . ',")' . $lock_script;
        } else {
            $on_login = "";
        }

        $bgservice = ':local dateint do={:local montharray ( "jan","feb","mar","apr","may","jun","jul","aug","sep","oct","nov","dec" );:local days [ :pick $d 4 6 ];:local month [ :pick $d 0 3 ];:local year [ :pick $d 7 11 ];:local monthint ([ :find $montharray $month]);:local month ($monthint + 1);:if ( [len $month] = 1) do={:local zero ("0");:return [:tonum ("$year$zero$month$days")];} else={:return [:tonum ("$year$month$days")];}}; :local timeint do={ :local hours [ :pick $t 0 2 ]; :local minutes [ :pick $t 3 5 ]; :return ($hours * 60 + $minutes) ; }; :local date [ /system clock get date ]; :local time [ /system clock get time ]; :local today [$dateint d=$date] ; :local curtime [$timeint t=$time] ; :foreach i in [ /ip hotspot user find where profile="' . $name . '" ] do={ :local comment [ /ip hotspot user get $i comment]; :local name [ /ip hotspot user get $i name]; :local gettime [:pic $comment 12 20]; :if ([:pic $comment 3] = "/" and [:pic $comment 6] = "/") do={:local expd [$dateint d=$comment] ; :local expt [$timeint t=$gettime] ; :if (($expd < $today and $expt < $curtime) or ($expd < $today and $expt > $curtime) or ($expd = $today and $expt < $curtime)) do={ [ /ip hotspot user ' . $mode . ' $i ]; [ /ip hotspot active remove [find where user=$name] ];}}}';

        $param = [
            'name'                  => $name,
            'address-pool'          => $request->input('pool') ?? 'none',
            'shared-users'          => $request->input('shared_users') == 0 ? 'unlimited' : $request->input('shared_users'),
            'rate-limit'            => $request->input('rate_limit'),
            "status-autorefresh"    => "1m",
            'on-login'              => $on_login,
            'parent-queue'          => $request->input('parent') ?? 'none',
        ];
        $scheduler = parent::$API->comm("/system/scheduler/print", array(
            "?name" => "$name",
        ));
        if ($expmode != "0") {
            if (!isset($scheduler[0]['.id'])) {
                parent::$API->comm("/system/scheduler/add", array(
                    "name"          => $name,
                    "start-time"    => "$randstarttime",
                    "interval"      => "$randinterval",
                    "on-event"      => "$bgservice",
                    "disabled"      => "no",
                    "comment"       => "Monitor Profile $name",
                ));
            } else {
                parent::$API->comm("/system/scheduler/set", array(
                    ".id"           => $scheduler[0]['.id'],
                    "name"          => $name,
                    "start-time"    => "$randstarttime",
                    "interval"      => "$randinterval",
                    "on-event"      => "$bgservice",
                    "disabled"      => "no",
                    "comment"       => "Monitor Profile $name",
                ));
            }
        } else {
            if (isset($scheduler[0]['.id'])) {
                parent::$API->comm("/system/scheduler/remove", array(
                    ".id" => $scheduler[0]['.id']
                ));
            }
        }
        return $param;
    }

    public static function update(string $id, Request $request)
    {
        $name = (preg_replace('/\s+/', '-', $request->input('name')));
        $expmode = $request->expired_mode;
        $lock_user = $request->lock_user;
        $randstarttime = "0" . rand(1, 5) . ":" . rand(10, 59) . ":" . rand(10, 59);
        $randinterval = "00:02:" . rand(10, 59);
        $mode = '';
        $price = $request->price;
        $selling_price = $request->selling_price;
        $day = $request->data_day;
        $time = parse_dtm_to_string($request->time_limit ?? '00:00:00');
        $validity = '';
        if ($day > 0) {
            $validity .= $day . 'd';
        }
        if (!empty($time)) {
            $validity .= $time;
        }
        if ($expmode != 0) {
        } else {
            $validity = '';
        }

        if ($lock_user == "Enable") {
            $lock_script = '; [:local mac $"mac-address"; /ip hotspot user set mac-address=$mac [find where name=$user]]';
        } else {
            $lock_script = "";
        }

        $record = '; :local mac $"mac-address"; :local time [/system clock get time ]; /system script add name="$date-|-$time-|-$user-|-' . $price . '-|-$address-|-$mac-|-' . $validity . '-|-' . $name . '-|-$comment" owner="$month$year" source="$date" comment="mikhmon"';

        $on_login = ':put (",' . $expmode . ',' . $price . ',' . $validity . ',' . $selling_price . ',,' . $lock_user . ',"); {:local comment [ /ip hotspot user get [/ip hotspot user find where name="$user"] comment]; :local ucode [:pic $comment 0 2]; :if ($ucode = "vc" or $ucode = "up" or $comment = "") do={ :local date [ /system clock get date ];:local year [ :pick $date 7 11 ];:local month [ :pick $date 0 3 ]; /sys sch add name="$user" disable=no start-date=$date interval="' . $validity . '"; :delay 5s; :local exp [ /sys sch get [ /sys sch find where name="$user" ] next-run]; :local getxp [len $exp]; :if ($getxp = 15) do={ :local d [:pic $exp 0 6]; :local t [:pic $exp 7 16]; :local s ("/"); :local exp ("$d$s$year $t"); /ip hotspot user set comment="$exp" [find where name="$user"];}; :if ($getxp = 8) do={ /ip hotspot user set comment="$date $exp" [find where name="$user"];}; :if ($getxp > 15) do={ /ip hotspot user set comment="$exp" [find where name="$user"];};:delay 5s; /sys sch remove [find where name="$user"]';
        if ($expmode == "rem") {
            $on_login = $on_login . $lock_script . "}}";
            $mode = "remove";
        } elseif ($expmode == "ntf") {
            $on_login = $on_login . $lock_script . "}}";
            $mode = "set limit-uptime=1s";
        } elseif ($expmode == "remc") {
            $on_login = $on_login . $record . $lock_script . "}}";
            $mode = "remove";
        } elseif ($expmode == "ntfc") {
            $on_login = $on_login . $record . $lock_script . "}}";
            $mode = "set limit-uptime=1s";
        } elseif ($expmode == "0" && $price > 0) {
            $on_login = ':put (",,' . $price . ',,,noexp,' . $lock_user . ',")' . $lock_script;
        } else {
            $on_login = "";
        }

        $bgservice = ':local dateint do={:local montharray ( "jan","feb","mar","apr","may","jun","jul","aug","sep","oct","nov","dec" );:local days [ :pick $d 4 6 ];:local month [ :pick $d 0 3 ];:local year [ :pick $d 7 11 ];:local monthint ([ :find $montharray $month]);:local month ($monthint + 1);:if ( [len $month] = 1) do={:local zero ("0");:return [:tonum ("$year$zero$month$days")];} else={:return [:tonum ("$year$month$days")];}}; :local timeint do={ :local hours [ :pick $t 0 2 ]; :local minutes [ :pick $t 3 5 ]; :return ($hours * 60 + $minutes) ; }; :local date [ /system clock get date ]; :local time [ /system clock get time ]; :local today [$dateint d=$date] ; :local curtime [$timeint t=$time] ; :foreach i in [ /ip hotspot user find where profile="' . $name . '" ] do={ :local comment [ /ip hotspot user get $i comment]; :local name [ /ip hotspot user get $i name]; :local gettime [:pic $comment 12 20]; :if ([:pic $comment 3] = "/" and [:pic $comment 6] = "/") do={:local expd [$dateint d=$comment] ; :local expt [$timeint t=$gettime] ; :if (($expd < $today and $expt < $curtime) or ($expd < $today and $expt > $curtime) or ($expd = $today and $expt < $curtime)) do={ [ /ip hotspot user ' . $mode . ' $i ]; [ /ip hotspot active remove [find where user=$name] ];}}}';

        $param = [
            'name'                  => $name,
            'address-pool'          => $request->input('pool') ?? 'none',
            'shared-users'          => $request->input('shared_users') == 0 ? 'unlimited' : $request->input('shared_users'),
            'rate-limit'            => $request->input('rate_limit'),
            "status-autorefresh"    => "1m",
            'on-login'              => $on_login,
            'parent-queue'          => $request->input('parent') ?? 'none',
        ];

        $new_param = array_merge(['.id' => $id], $param);
        $response = parent::$API->comm(parent::$command . "set", $new_param);
        parent::cek_error($response);
        $data = static::show($id);
        if (parent::$cache) {
            // $data = static::show($id);
            $cache = static::update_item_to_cache($id, $data);
        }
        $scheduler = parent::$API->comm("/system/scheduler/print", array(
            "?name" => $data['name'],
        ));
        if ($expmode != "0") {
            if (!isset($scheduler[0]['.id'])) {
                parent::$API->comm("/system/scheduler/add", array(
                    "name"          => $name,
                    "start-time"    => "$randstarttime",
                    "interval"      => "$randinterval",
                    "on-event"      => "$bgservice",
                    "disabled"      => "no",
                    "comment"       => "Monitor Profile $name",
                ));
            } else {
                parent::$API->comm("/system/scheduler/set", array(
                    ".id"           => $scheduler[0]['.id'],
                    "name"          => $name,
                    "start-time"    => "$randstarttime",
                    "interval"      => "$randinterval",
                    "on-event"      => "$bgservice",
                    "disabled"      => "no",
                    "comment"       => "Monitor Profile $name",
                ));
            }
        } else {
            if (isset($scheduler[0]['.id'])) {
                parent::$API->comm("/system/scheduler/remove", array(
                    ".id" => $scheduler[0]['.id']
                ));
            }
        }
        return $response;
    }
}
