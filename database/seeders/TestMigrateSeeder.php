<?php

namespace Database\Seeders;

use App\Models\BalanceHistory;
use App\Models\Bank;
use App\Models\Company;
use App\Models\Port;
use App\Models\Server;
use App\Models\TemporaryIp;
use App\Models\Topup;
use App\Models\User;
use App\Models\Vpn;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestMigrateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $db = json_decode(file_get_contents(public_path('json/kncet.json')), true);

        // users
        foreach ($db as $data) {
            if ($data['type'] == 'table' && $data['name'] == 'users') {
                foreach ($data['data'] as $item) {
                    $param_user = [
                        "id"                => $item['id'],
                        'name'              => $item['name'],
                        "email"             => $item['email'],
                        "gender"            => $item['gender'],
                        "address"           => $item['address'],
                        "phone"             => $item['phone'],
                        "email_verified_at" => $item['email_verified_at'],
                        "password"          => $item['password'],
                        "balance"           => $item['balance'],
                        "router_limit"      => $item['router_limit'],
                        "last_login_at"     => $item['last_login_at'],
                        "last_login_ip"     => $item['last_login_ip'],
                        "avatar"            => $item['avatar'],
                        "role"              => $item['role'],
                        "status"            => $item['status'],
                        "instagram"         => $item['instagram'],
                        "facebook"          => $item['facebook'],
                        "linkedin"          => $item['linkedin'],
                        "github"            => $item['github'],
                        "remember_token"    => $item['remember_token'],
                        "created_at"        => $item['created_at'],
                        "updated_at"        => $item['updated_at'],
                    ];
                    User::create($param_user);
                }
            }
        }

        // servers
        foreach ($db as $data) {
            if ($data['type'] == 'table' && $data['name'] == 'servers') {
                foreach ($data['data'] as $item) {
                    $param_server = [
                        "id"            => $item['id'],
                        'name'          => $item['name'],
                        'username'      => $item['username'],
                        'password'      => $item['password'],
                        "ip"            => $item['ip'],
                        "domain"        => $item['domain'],
                        "netwatch"      => $item['netwatch'],
                        "location"      => $item['location'],
                        "sufiks"        => $item['sufiks'],
                        "port"          => $item['port'],
                        "price"         => $item['price'],
                        "annual_price"  => $item['annual_price'],
                        "last_ip"       => $item['last_ip'],
                        'is_active'     => $item['is_active'] == 'yes' ? true : false,
                        'is_available'  => $item['is_available'] == 'yes' ? true : false,
                        "created_at"    => $item['created_at'],
                        "updated_at"    => $item['updated_at'],
                    ];
                    Server::create($param_server);
                }
            }
        }

        // vpns
        foreach ($db as $data) {
            if ($data['type'] == 'table' && $data['name'] == 'vpns') {
                foreach ($data['data'] as $item) {
                    $param_vpn = [
                        "id"                        => $item['id'],
                        "user_id"                   => $item['user_id'],
                        "server_id"                 => $item['server_id'],
                        "ip"                        => $item['ip'],
                        "username"                  => $item['username'],
                        "password"                  => $item['password'],
                        "auto_renew"                => $item['auto_renew'] == 'yes' ? true : false,
                        "last_renew"                => $item['last_renew'],
                        "expired"                   => $item['expired'],
                        "is_active"                 => $item['is_active'] == 'yes' ? true : false,
                        "is_trial"                  => $item['is_trial'] == 'yes' ? true : false,
                        "desc"                      => $item['desc'],
                        "last_send_notification"    => $item['last_email'],
                        "created_at"                => $item['created_at'],
                        "updated_at"                => $item['updated_at'],
                    ];
                    Vpn::create($param_vpn);
                }
            }
        }

        // ports
        foreach ($db as $data) {
            if ($data['type'] == 'table' && $data['name'] == 'ports') {
                foreach ($data['data'] as $item) {
                    $param_port = [
                        "id"            => $item['id'],
                        "vpn_id"        => $item['vpn_id'],
                        "dst"           => $item['dst'],
                        "to"            => $item['to'],
                        "created_at"    => $item['created_at'],
                        "updated_at"    => $item['updated_at'],
                    ];
                    Port::create($param_port);
                }
            }
        }

        // banks
        foreach ($db as $data) {
            if ($data['type'] == 'table' && $data['name'] == 'banks') {
                foreach ($data['data'] as $item) {
                    $param_bank = [
                        "id"            => $item['id'],
                        "name"          => $item['name'],
                        "acc_name"      => $item['acc_name'],
                        "acc_number"    => $item['acc_number'],
                        "is_active"     => $item['is_active'] == 'yes' ? true : false,
                        "created_at"    => $item['created_at'],
                        "updated_at"    => $item['updated_at'],
                    ];
                    Bank::create($param_bank);
                }
            }
        }


        // temporary ips
        foreach ($db as $data) {
            if ($data['type'] == 'table' && $data['name'] == 'temporary_ips') {
                foreach ($data['data'] as $item) {
                    $param_temp = [
                        'id'            => $item['id'],
                        'server_id'     => $item['server_id'],
                        'ip'            => $item['ip'],
                        'web'           => $item['web'],
                        'api'           => $item['api'],
                        'win'           => $item['win'],
                        'created_at'    => $item['created_at'],
                        'updated_at'    => $item['updated_at'],
                    ];
                    TemporaryIp::create($param_temp);
                }
            }
        }

        // topups
        foreach ($db as $data) {
            if ($data['type'] == 'table' && $data['name'] == 'topups') {
                foreach ($data['data'] as $item) {
                    $param_top = [
                        'id'            => $item['id'],
                        'user_id'       => $item['user_id'],
                        'bank_id'       => $item['bank_id'],
                        'date'          => $item['date'],
                        'number'        => $item['number'],
                        'amount'        => $item['amount'],
                        'status'        => $item['status'],
                        'image'         => $item['image'],
                        'desc'          => $item['desc'],
                        'created_at'    => $item['created_at'],
                        'updated_at'    => $item['updated_at'],
                    ];
                    Topup::create($param_top);
                }
            }
        }

        // balance history
        foreach ($db as $data) {
            if ($data['type'] == 'table' && $data['name'] == 'balance_histories') {
                foreach ($data['data'] as $item) {
                    $param_balance = [
                        'id'            => $item['id'],
                        'user_id'       => $item['user_id'],
                        'date'          => $item['date'],
                        'amount'        => $item['amount'],
                        'before'        => $item['before'],
                        'after'         => $item['after'],
                        'type'          => $item['type'],
                        'desc'          => $item['desc'],
                        'created_at'    => $item['created_at'],
                        'updated_at'    => $item['updated_at'],
                    ];
                    BalanceHistory::create($param_balance);
                }
            }
        }

        // Company
        foreach ($db as $data) {
            if ($data['type'] == 'table' && $data['name'] == 'companies') {
                foreach ($data['data'] as $item) {
                    $param_comp = [
                        'id'            => $item['id'],
                        'name'          => $item['name'],
                        'email'         => $item['email'],
                        'phone'         => $item['phone'],
                        'slogan'        => $item['slogan'],
                        'author'        => $item['author'],
                        'address'       => $item['address'],
                        'logo_light'    => $item['logo_light'],
                        'logo_dark'     => $item['logo_dark'],
                        'link_blog'     => $item['link_blog'],
                        'link_status'   => $item['link_status'],
                        'facebook'      => $item['facebook'],
                        'instagram'     => $item['instagram'],
                        'github'        => $item['github'],
                        'linkedin'      => $item['linkedin'],
                        'twitter'       => $item['twitter'],
                        'created_at'    => $item['created_at'],
                        'updated_at'    => $item['updated_at'],
                    ];
                    Company::create($param_comp);
                }
            }
        }
    }
}
