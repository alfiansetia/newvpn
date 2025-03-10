<?php

use App\Models\Company;
use Illuminate\Support\Carbon;

function cdn($path = '')
{
    $cdn_url = config('app.cdn');
    $url = rtrim($cdn_url, '/') . '/';
    return empty($cdn_url) ? asset($path) : ($url . $path);
}

function company()
{
    return Company::first();
}

function user()
{
    return auth()->user();
}

function isAdmin()
{
    $user = auth()->user();
    if (!$user) {
        return false;
    }
    return strtolower(auth()->user()->role) == 'admin';
}

function formatBytes($size, $decimals = 0)
{
    $unit = array(
        '0' => 'Byte',
        '1' => 'KiB',
        '2' => 'MiB',
        '3' => 'GiB',
        '4' => 'TiB',
        '5' => 'PiB',
        '6' => 'EiB',
        '7' => 'ZiB',
        '8' => 'YiB'
    );

    for ($i = 0; $size >= 1024 && $i <= count($unit); $i++) {
        $size = $size / 1024;
    }

    return round($size, $decimals) . ' ' . $unit[$i];
}

function formatInterval($dtm)
{
    $val_convert = $dtm;
    $new_format = str_replace("s", "", str_replace("m", "m ", str_replace("h", "h ", str_replace("d", "d ", str_replace("w", "w ", $val_convert)))));
    return $new_format;
}

function formatDTM($dtm)
{
    if (empty($dtm)) {
        return null;
    }
    $day = '';
    if (substr($dtm, 1, 1) == "d" || substr($dtm, 2, 1) == "d") {
        $day = explode("d", $dtm)[0] . "d";
        $day = str_replace("d", "d ", str_replace("w", "w ", $day));
        $dtm = explode("d", $dtm)[1];
    } elseif (substr($dtm, 1, 1) == "w" && substr($dtm, 3, 1) == "d" || substr($dtm, 2, 1) == "w" && substr($dtm, 4, 1) == "d") {
        $day = explode("d", $dtm)[0] . "d";
        $day = str_replace("d", "d ", str_replace("w", "w ", $day));
        $dtm = explode("d", $dtm)[1];
    } elseif (substr($dtm, 1, 1) == "w" || substr($dtm, 2, 1) == "w") {
        $day = explode("w", $dtm)[0] . "w";
        $day = str_replace("d", "d ", str_replace("w", "w ", $day));
        $dtm = explode("w", $dtm)[1];
    }

    // secs
    if (strlen($dtm) == "2" && substr($dtm, -1) == "s") {
        $format = $day . " 00:00:0" . substr($dtm, 0, -1);
    } elseif (strlen($dtm) == "3" && substr($dtm, -1) == "s") {
        $format = $day . " 00:00:" . substr($dtm, 0, -1);
        //minutes
    } elseif (strlen($dtm) == "2" && substr($dtm, -1) == "m") {
        $format = $day . " 00:0" . substr($dtm, 0, -1) . ":00";
    } elseif (strlen($dtm) == "3" && substr($dtm, -1) == "m") {
        $format = $day . " 00:" . substr($dtm, 0, -1) . ":00";
        //hours
    } elseif (strlen($dtm) == "2" && substr($dtm, -1) == "h") {
        $format = $day . " 0" . substr($dtm, 0, -1) . ":00:00";
    } elseif (strlen($dtm) == "3" && substr($dtm, -1) == "h") {
        $format = $day . " " . substr($dtm, 0, -1) . ":00:00";

        //minutes -secs
    } elseif (strlen($dtm) == "4" && substr($dtm, -1) == "s" && substr($dtm, 1, -2) == "m") {
        $format = $day . " " . "00:0" . substr($dtm, 0, 1) . ":0" . substr($dtm, 2, -1);
    } elseif (strlen($dtm) == "5" && substr($dtm, -1) == "s" && substr($dtm, 1, -3) == "m") {
        $format = $day . " " . "00:0" . substr($dtm, 0, 1) . ":" . substr($dtm, 2, -1);
    } elseif (strlen($dtm) == "5" && substr($dtm, -1) == "s" && substr($dtm, 2, -2) == "m") {
        $format = $day . " " . "00:" . substr($dtm, 0, 2) . ":0" . substr($dtm, 3, -1);
    } elseif (strlen($dtm) == "6" && substr($dtm, -1) == "s" && substr($dtm, 2, -3) == "m") {
        $format = $day . " " . "00:" . substr($dtm, 0, 2) . ":" . substr($dtm, 3, -1);

        //hours -secs
    } elseif (strlen($dtm) == "4" && substr($dtm, -1) == "s" && substr($dtm, 1, -2) == "h") {
        $format = $day . " 0" . substr($dtm, 0, 1) . ":00:0" . substr($dtm, 2, -1);
    } elseif (strlen($dtm) == "5" && substr($dtm, -1) == "s" && substr($dtm, 1, -3) == "h") {
        $format = $day . " 0" . substr($dtm, 0, 1) . ":00:" . substr($dtm, 2, -1);
    } elseif (strlen($dtm) == "5" && substr($dtm, -1) == "s" && substr($dtm, 2, -2) == "h") {
        $format = $day . " " . substr($dtm, 0, 2) . ":00:0" . substr($dtm, 3, -1);
    } elseif (strlen($dtm) == "6" && substr($dtm, -1) == "s" && substr($dtm, 2, -3) == "h") {
        $format = $day . " " . substr($dtm, 0, 2) . ":00:" . substr($dtm, 3, -1);

        //hours -secs
    } elseif (strlen($dtm) == "4" && substr($dtm, -1) == "m" && substr($dtm, 1, -2) == "h") {
        $format = $day . " 0" . substr($dtm, 0, 1) . ":0" . substr($dtm, 2, -1) . ":00";
    } elseif (strlen($dtm) == "5" && substr($dtm, -1) == "m" && substr($dtm, 1, -3) == "h") {
        $format = $day . " 0" . substr($dtm, 0, 1) . ":" . substr($dtm, 2, -1) . ":00";
    } elseif (strlen($dtm) == "5" && substr($dtm, -1) == "m" && substr($dtm, 2, -2) == "h") {
        $format = $day . " " . substr($dtm, 0, 2) . ":0" . substr($dtm, 3, -1) . ":00";
    } elseif (strlen($dtm) == "6" && substr($dtm, -1) == "m" && substr($dtm, 2, -3) == "h") {
        $format = $day . " " . substr($dtm, 0, 2) . ":" . substr($dtm, 3, -1) . ":00";

        //hours minutes secs
    } elseif (strlen($dtm) == "6" && substr($dtm, -1) == "s" && substr($dtm, 3, -2) == "m" && substr($dtm, 1, -4) == "h") {
        $format = $day . " 0" . substr($dtm, 0, 1) . ":0" . substr($dtm, 2, -3) . ":0" . substr($dtm, 4, -1);
    } elseif (strlen($dtm) == "7" && substr($dtm, -1) == "s" && substr($dtm, 3, -3) == "m" && substr($dtm, 1, -5) == "h") {
        $format = $day . " 0" . substr($dtm, 0, 1) . ":0" . substr($dtm, 2, -4) . ":" . substr($dtm, 4, -1);
    } elseif (strlen($dtm) == "7" && substr($dtm, -1) == "s" && substr($dtm, 4, -2) == "m" && substr($dtm, 1, -5) == "h") {
        $format = $day . " 0" . substr($dtm, 0, 1) . ":" . substr($dtm, 2, -3) . ":0" . substr($dtm, 5, -1);
    } elseif (strlen($dtm) == "8" && substr($dtm, -1) == "s" && substr($dtm, 4, -3) == "m" && substr($dtm, 1, -6) == "h") {
        $format = $day . " 0" . substr($dtm, 0, 1) . ":" . substr($dtm, 2, -4) . ":" . substr($dtm, 5, -1);
    } elseif (strlen($dtm) == "7" && substr($dtm, -1) == "s" && substr($dtm, 4, -2) == "m" && substr($dtm, 2, -4) == "h") {
        $format = $day . " " . substr($dtm, 0, 2) . ":0" . substr($dtm, 3, -3) . ":0" . substr($dtm, 5, -1);
    } elseif (strlen($dtm) == "8" && substr($dtm, -1) == "s" && substr($dtm, 4, -3) == "m" && substr($dtm, 2, -5) == "h") {
        $format = $day . " " . substr($dtm, 0, 2) . ":0" . substr($dtm, 3, -4) . ":" . substr($dtm, 5, -1);
    } elseif (strlen($dtm) == "8" && substr($dtm, -1) == "s" && substr($dtm, 5, -2) == "m" && substr($dtm, 2, -5) == "h") {
        $format = $day . " " . substr($dtm, 0, 2) . ":" . substr($dtm, 3, -3) . ":0" . substr($dtm, 6, -1);
    } elseif (strlen($dtm) == "9" && substr($dtm, -1) == "s" && substr($dtm, 5, -3) == "m" && substr($dtm, 2, -6) == "h") {
        $format = $day . " " . substr($dtm, 0, 2) . ":" . substr($dtm, 3, -4) . ":" . substr($dtm, 6, -1);
    } else {
        $format = $dtm;
    }
    return $format;
}

function cek_package($packages, $package)
{
    try {
        $search = array_search($package, array_column($packages, 'name'));
        if ($search == false && $packages[$search]['disabled'] == 'true') {
            return false;
        }
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function handle_no_package($name)
{
    throw new Exception("No Package! $name found on Router");
}

function handle_not_found()
{
    return  ['status' => false, 'message' => 'Data Not Found', 'data' => []];
}

function throw_not_found()
{
    throw new Exception('Data Not Found');
}


function handle_fail_login($api)
{
    if ($api->error_str == "") {
        $api->error_str = "User/Password Wrong!";
    }
    $message = 'Router Not Connect : ' . $api->error_str;
    throw new Exception($message);
}


function is_error($response)
{
    try {
        if (isset($response['!trap'])) {
            return true;
        }
        return false;
    } catch (Exception $e) {
        return  true;
    }
}

function cek_error($response)
{
    if (isset($response['!trap'])) {
        throw new Exception('Error : ' . $response['!trap'][0]['message']);
    }
}

function cek_exists($response)
{
    if (count($response) > 0) {
        throw new Exception('Data Already Exist!');
    }
}

function handle_data($response, $message = '')
{
    try {
        if (isset($response['!trap'])) {
            return  ['status' => false, 'message' => $response['!trap'][0]['message'], 'data' => []];
        }
        return ['status' => true, 'message' => $message, 'data' => $response];
    } catch (Exception $e) {
        return  ['status' => false, 'message' => 'Server Error', 'data' => $response];
    }
}

function handle_data_edit($response)
{
    if (count($response) < 1) {
        throw_not_found();
    }
    return $response[0];
}

function generateUsername(string $string)
{
    $username = strtolower($string);
    $username = preg_replace('/[^a-zA-Z0-9_]/', '', $username);
    return $username;
}


function date_log(string $date)
{
    if (empty($date)) {
        return strtolower(date('M/d H:i:s'));
    }
    $parts = explode(' ', $date);
    if (count($parts) == 2) {
        return $date;
    } else {
        return strtolower(date('M/d') . ' ' . $date);
    }
}

function hrg($angka)
{
    return number_format($angka, 0, ',', '.');
}


function dtm_new($timeString)
{
    if (empty($timeString)) {
        return '00:00:00';
    }
    preg_match('/(?:(\d+)w)?(?:(\d+)d)?(?:(\d+)h)?(?:(\d+)m)?(?:(\d+)s)?/', $timeString, $matches);
    $weeks = isset($matches[1]) ? (int)$matches[1] : 0;
    $days = isset($matches[2]) ? (int)$matches[2] : 0;
    $hours = isset($matches[3]) ? (int)$matches[3] : 0;
    $minutes = isset($matches[4]) ? (int)$matches[4] : 0;
    $seconds = isset($matches[5]) ? (int)$matches[5] : 0;

    $carbon = Carbon::now()->startOfDay()
        ->addDays($weeks * 7 + $days)
        ->addHours($hours)
        ->addMinutes($minutes)
        ->addSeconds($seconds);

    $outputParts = [];
    if ($weeks > 0) {
        $outputParts[] = "{$weeks}w";
    }
    if ($days > 0) {
        $outputParts[] = "{$days}d";
    }
    $outputParts[] = sprintf("%02d:%02d:%02d", $carbon->hour, $carbon->minute, $carbon->second);
    $output = implode(' ', $outputParts);
    return $output;
}

function dtm_new_array($timeString)
{
    if (empty($timeString)) {
        return [
            'time'  => '00:00:00',
            'day'   => 0,
        ];
    }

    preg_match('/(?:(\d+)w)?(?:(\d+)d)?(?:(\d+)h)?(?:(\d+)m)?(?:(\d+)s)?/', $timeString, $matches);
    $weeks = isset($matches[1]) ? (int)$matches[1] : 0;
    $days = isset($matches[2]) ? (int)$matches[2] : 0;
    $hours = isset($matches[3]) ? (int)$matches[3] : 0;
    $minutes = isset($matches[4]) ? (int)$matches[4] : 0;
    $seconds = isset($matches[5]) ? (int)$matches[5] : 0;

    $carbon = Carbon::now()->startOfDay()
        ->addDays($weeks * 7 + $days)
        ->addHours($hours)
        ->addMinutes($minutes)
        ->addSeconds($seconds);

    $outputParts = [];
    if ($weeks > 0) {
        $outputParts[] = "{$weeks}w";
    }
    if ($days > 0) {
        $outputParts[] = "{$days}d";
    }
    $day = ($weeks * 7) + $days;
    $time = sprintf("%02d:%02d:%02d", $carbon->hour, $carbon->minute, $carbon->second);
    return [
        'time'  => $time,
        'day'   => $day,
    ];
}

function dtm_array_all($timeString)
{
    if (empty($timeString)) {
        return [
            'd' => 0,
            'h' => 0,
            'm' => 0,
            's' => 0,
        ];
    }

    preg_match('/(?:(\d+)w)?(?:(\d+)d)?(?:(\d+)h)?(?:(\d+)m)?(?:(\d+)s)?/', $timeString, $matches);
    $weeks = isset($matches[1]) ? (int)$matches[1] : 0;
    $days = isset($matches[2]) ? (int)$matches[2] : 0;
    $hours = isset($matches[3]) ? (int)$matches[3] : 0;
    $minutes = isset($matches[4]) ? (int)$matches[4] : 0;
    $seconds = isset($matches[5]) ? (int)$matches[5] : 0;

    $carbon = Carbon::now()->startOfDay()
        ->addDays($weeks * 7 + $days)
        ->addHours($hours)
        ->addMinutes($minutes)
        ->addSeconds($seconds);

    $outputParts = [];
    if ($weeks > 0) {
        $outputParts[] = "{$weeks}w";
    }
    if ($days > 0) {
        $outputParts[] = "{$days}d";
    }
    $day = ($weeks * 7) + $days;
    return [
        'd' => $day,
        'h' => $carbon->hour,
        'm' => $carbon->minute,
        's' => $carbon->second,
    ];
}


function salam(): string
{
    $hour = date('H');

    if ($hour >= 5 && $hour < 12) {
        return 'Selamat Pagi ';
    } elseif ($hour >= 12 && $hour < 15) {
        return 'Selamat Siang ';
    } elseif ($hour >= 15 && $hour < 18) {
        return 'Selamat Sore ';
    } else {
        return 'Selamat Malam ';
    }
}

function getx($profile, $profiles)
{
    $profile = collect($profiles)->where('name', $profile)->first();
    if (!$profile) {
        return 0;
    }
    if ($profile['mikhmon']) {
        return $profile['mikhmon']['selling_price'];
    } else {
        return 0;
    }
}


function getrandomclass()
{
    $class = ['primary', 'secondary', 'warning', 'danger', 'info', 'success', 'dark'];
    return $class[random_int(0, 6)];
}


function get_mikhmon_profile_data($on_login)
{
    $mikhmon = null;
    $getmikhmon = explode(",", $on_login);
    if (count($getmikhmon) > 6) {
        $expmode = $getmikhmon[1] ?? null;
        if ($expmode == "rem") {
            $mode = "Remove";
        } elseif ($expmode == "ntf") {
            $mode = "Notice";
        } elseif ($expmode == "remc") {
            $mode = "Remove & Record";
        } elseif ($expmode == "ntfc") {
            $mode = "Notice & Record";
        } else {
            $mode = 'None';
            $expmode = 0;
        }
        $validity = !empty($getmikhmon[3]) ? $getmikhmon[3] : null;
        $mikhmon['exp_mode'] = $expmode;
        $mikhmon['exp_mode_parse'] = $mode;
        $mikhmon['price'] = !empty($getmikhmon[2]) ? $getmikhmon[2] : 0;
        $mikhmon['selling_price'] = !empty($getmikhmon[4]) ? $getmikhmon[4] : 0;
        $mikhmon['validity'] = $validity;
        $mikhmon['validity_parse'] = dtm_new_array($validity);
        $mikhmon['lock'] = !empty($getmikhmon[6]) ? $getmikhmon[6] : 'Disable';
        $mikhmon['count'] = count($getmikhmon);
        $mikhmon['explode'] = $getmikhmon;
    }
    return $mikhmon;
}


function parse_dtm_to_string($time = '00:00:00')
{
    if ($time == '00:00:00' || empty($time)) {
        return '';
    }
    list($hours, $minutes, $seconds) = explode(':', $time);
    $result = '';
    if ((int)$hours > 0) {
        $result .= (int)$hours . 'h';
    }
    if ((int)$minutes > 0) {
        $result .= (int)$minutes . 'm';
    }
    if ((int)$seconds > 0) {
        $result .= (int)$seconds . 's';
    }
    return $result;
}


function get_batch($length, $batchSize)
{
    // $batches = [];
    // if ($length <= $batchSize) {
    //     $batches[] = $length;
    //     return $batches;
    // }

    // $totalBatch = ceil($length / $batchSize);
    // $totalLoop = $totalBatch;
    // if ($totalBatch * $batchSize > $length) {
    //     $totalLoop = $totalBatch - 1;
    // }
    // for ($i = 0; $i < $totalLoop; $i++) {
    //     $batches[] = $batchSize;
    // }
    // if (($totalLoop * $batchSize) < $length) {
    //     $batches[$totalBatch] =  $length - ($totalLoop * $batchSize);
    // }
    // return $batches;
    $batches = [];

    while ($length > 0) {
        $currentBatch = min($length, $batchSize);
        $batches[] = $currentBatch;
        $length -= $currentBatch;
    }

    return $batches;
}
