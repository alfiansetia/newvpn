<?php

namespace App\Services\Mikapi\Hotspot;

use App\Services\Mikapi\GenerateRandom;
use App\Services\RouterApiServices;
use App\Traits\CrudApiTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserServices extends RouterApiServices
{
    use CrudApiTrait;

    public function __construct()
    {
        parent::__construct();

        parent::$name = 'hotspot';
        parent::$command = '/ip/hotspot/user/';
        parent::$path = storage_path('app/mikapi/hotspot/user');
        parent::$cache = true;
    }
    public static function generate(Request $request)
    {
        $server = $request->input('server');
        $profile = $request->input('profile');
        $limit_uptime = ($request->data_day ?? 0) . 'd ' . $request->time_limit;
        $limit_byte_total = $request->data_limit . $request->data_type;
        $char = $request->character;
        $user_mode = $request->user_mode;
        $comment =  $user_mode . "-" . rand(100, 999) . "-" . date("m.d.y") . "-" . $request->comment;
        $length = $request->length;
        $users = [];
        $passwords = [];

        for ($i = 0; $i < $request->qty; $i++) {
            if ($char == 'num') {
                $user = GenerateRandom::withNumber()->get($length);
                $pass = GenerateRandom::withNumber()->get($length);
            } elseif ($char == 'up') {
                $user = GenerateRandom::withUpper()->get($length);
                $pass = GenerateRandom::withUpper()->get($length);
            } elseif ($char == 'low') {
                $user = GenerateRandom::withLower()->get($length);
                $pass = GenerateRandom::withLower()->get($length);
            } elseif ($char == 'uplow') {
                $user = GenerateRandom::withUpper()->withLower()->get($length);
                $pass = GenerateRandom::withUpper()->withLower()->get($length);
            } elseif ($char == 'numlow') {
                $user = GenerateRandom::withNumber()->withLower()->get($length);
                $pass = GenerateRandom::withNumber()->withLower()->get($length);
            } elseif ($char == 'numup') {
                $user = GenerateRandom::withNumber()->withUpper()->get($length);
                $pass = GenerateRandom::withNumber()->withUpper()->get($length);
            } else {
                $user = GenerateRandom::get($length);
                $pass = GenerateRandom::get($length);
            }
            $users[] = $request->prefix . $user;
            $passwords[] = $pass;
        }

        $new_users = array_values(array_unique($users));

        foreach ($new_users as $key => $item) {
            $passw = $user_mode == 'up' ? $passwords[$key] : $item;
            $param = [
                'server'             => $server,
                'profile'            => $profile,
                'name'               => $item,
                'password'           => $passw,
                'limit-uptime'       => $limit_uptime,
                'limit-bytes-total'  => $limit_byte_total,
                'comment'            => $comment,
                'disabled'           => 'no',
            ];
            $id = parent::$API->comm(parent::$command . "add", $param);
        }
        return true;
    }


    // public static function generate(Request $request)
    // {
    //     $file_name = 'api';
    //     $file_name_ext = $file_name . '.txt';
    //     $files = parent::$API->comm('/file/print', [
    //         'file' => $file_name,
    //         '?type' => '.txt file'
    //     ]);

    //     $server = $request->input('server');
    //     $profile = $request->input('profile');
    //     $limit_uptime = ($request->data_day ?? 0) . 'd ' . $request->time_limit;
    //     $limit_byte_total = $request->data_limit . $request->data_type;
    //     $char = $request->character;
    //     $user_mode = $request->user_mode;
    //     $comment =  $user_mode . "-" . rand(100, 999) . "-" . date("m.d.y") . "-" . $request->comment;
    //     $length = $request->length;

    //     $users = [];
    //     $passwords = [];

    //     for ($i = 0; $i < $request->qty; $i++) {
    //         if ($char == 'num') {
    //             $user = GenerateRandom::withNumber()->get($length);
    //             $pass = GenerateRandom::withNumber()->get($length);
    //         } elseif ($char == 'up') {
    //             $user = GenerateRandom::withUpper()->get($length);
    //             $pass = GenerateRandom::withUpper()->get($length);
    //         } elseif ($char == 'low') {
    //             $user = GenerateRandom::withLower()->get($length);
    //             $pass = GenerateRandom::withLower()->get($length);
    //         } elseif ($char == 'uplow') {
    //             $user = GenerateRandom::withUpper()->withLower()->get($length);
    //             $pass = GenerateRandom::withUpper()->withLower()->get($length);
    //         } elseif ($char == 'numlow') {
    //             $user = GenerateRandom::withNumber()->withLower()->get($length);
    //             $pass = GenerateRandom::withNumber()->withLower()->get($length);
    //         } elseif ($char == 'numup') {
    //             $user = GenerateRandom::withNumber()->withUpper()->get($length);
    //             $pass = GenerateRandom::withNumber()->withUpper()->get($length);
    //         } else {
    //             $user = GenerateRandom::get($length);
    //             $pass = GenerateRandom::get($length);
    //         }
    //         $users[] = $request->prefix . $user;
    //         $passwords[] = $pass;
    //     }


    //     $new_chars = array_values(array_unique($users));
    //     if (count($new_chars) <= count($passwords)) {
    //         // 
    //     }
    //     // $param = [
    //     //     'server'             => $server,
    //     //     'profile'            => $profile,
    //     //     'name'               => $item,
    //     //     'password'           => $passw,
    //     //     'limit-uptime'       => $limit_uptime,
    //     //     'limit-bytes-total'  => $limit_byte_total,
    //     //     'comment'            => $comment,
    //     //     'disabled'           => 'no',
    //     // ];
    //     // $id = parent::$API->comm(parent::$command . "add", $param);
    //     $script = '';
    //     $path = 'mikapi/x.txt';
    //     Storage::put($path, '/log warning "Generating ' . count($new_chars) . ' Voucher..."; ');
    //     // $script .= '/log warning "Generating ' . count($new_chars) . ' Voucher..."; ';

    //     foreach ($new_chars as $key => $item) {
    //         $script = '';
    //         $passw = $user_mode == 'up' ? $passwords[$key] : $item;
    //         $script .= ':do { ';
    //         $script .= '/ip hotspot user add server="' . $server . '" profile="' . $profile . '" name="' . $item . '" ';
    //         $script .= 'password="' . $passw . '" limit-uptime="' . $limit_uptime . '" limit-bytes-total="' . $limit_byte_total . '" ';
    //         $script .= 'comment="' . $comment . '" disabled="no"; ';
    //         $script .= '} on-error={}; ';
    //         Storage::append($path, $script);
    //     }
    //     Storage::append($path, '/log warning "Done Generating Voucher!"; ');
    //     // $script .= '/log warning "Done Generating Voucher!"; ';

    //     $id_file = '';
    //     while (empty($id_file)) {
    //         $file = parent::$API->comm('/file/print', [
    //             '?name' => $file_name_ext,
    //             '?type' => '.txt file'
    //         ]);

    //         if (isset($file[0]['.id'])) {
    //             $id_file = $file[0]['.id'];
    //         }
    //     }

    //     $content = Storage::get($path);
    //     // dd($content);

    //     parent::$API->comm('/file/set', [
    //         '.id'       => $id_file,
    //         'contents' => $content = str_replace(["\r\n", "\n"], '', $content),
    //     ]);

    //     // $import = parent::$API->comm('/import', [
    //     //     'file-name' => $file_name_ext
    //     // ]);
    //     // return $import;
    //     return $content;
    // }
}
