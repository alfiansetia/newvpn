<?php

namespace App\Http\Controllers;

use App\Mail\DetailVpnMail;
use App\Models\BalanceHistory;
use App\Models\Port;
use App\Models\Server;
use App\Models\TemporaryIp;
use App\Models\Vpn;
use App\Services\ServerApiServices;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Throwable;

class VpnController extends Controller
{

    public function index(Request $request)
    {
        if (isAdmin()) {
            return view('vpn.index');
        } else {
            return view('vpn.index_user');
        }
    }

    public function create(Request $request)
    {
        $servers = Server::where('is_active', 'yes')->where('is_available', 'yes')->get();
        return view('vpn.create_auto', compact('servers'));
    }

    public function autoCreate(Request $request)
    {
        $user = $this->getUser();
        $count_trial = Vpn::where('user_id', '=', $user->id)->where('is_trial', '=', 'yes')->count();
        if (isAdmin()) {
            $count_trial = 0;
        }
        if ($count_trial > 0) {
            return response()->json([
                'message'   => 'Trial Sudah Ada, Silahkan Selesaikan Pembayaran Dahulu Untuk membuat Trial Lagi!',
                'data'      => ''
            ], 403);
        }
        $this->validate($request, [
            'server'    => [
                'required',
                'integer',
                Rule::exists('servers', 'id')->where(function ($query) {
                    $query->where('is_active', 'yes')->where('is_available', 'yes');
                }),
            ],
            'username'  => [
                'required',
                'string',
                'max:50',
                'min:4',
                function ($attribute, $value, $fail) use ($request) {
                    $server = Server::find($request->input('server'));
                    if ($server) {
                        $vpn = Vpn::where('server_id', $server->id)
                            ->where('username', (generateUsername($value) . ($server->sufiks ?? '')))->first();
                        if ($vpn) {
                            $fail('Username is invalid!');
                        }
                    }
                },
            ],
            'password'  => 'required|string|max:50|min:4',
        ]);
        DB::beginTransaction();
        try {
            $server = Server::find($request->input('server'));
            $temp = TemporaryIp::where('server_id', $server->id)->first();
            $reg = date('Y-m-d');
            $exp = date('Y-m-d', strtotime('+1 day', strtotime($reg)));
            $to = [80, 8728, 8291];
            $netw = $server->netwatch;
            if ($temp) {
                $jadi = $temp->ip;
                $dst = [$temp->web, $temp->api, $temp->win];
            } else {
                $pecah_last_ip = explode('.', $server->last_ip);
                $pecah_netwatch = explode('.', $netw);
                $last_ip = $pecah_last_ip[2];
                $last_count = $pecah_last_ip[3];
                $last_port = $pecah_last_ip[2] - $pecah_netwatch[2] + 1;
                if ($last_count >= 199) {
                    $last_ip = $last_ip + 1;
                    $last_count = 9;
                    $last_port = $last_port + 1;
                }
                $portweb = 7000 + ($last_port * 100) + (($last_port - 1) * 100) + $last_count + 1;
                $portapi = 8000 + ($last_port * 100) + (($last_port - 1) * 100) + $last_count + 1;
                $portwin = 9000 + ($last_port * 100) + (($last_port - 1) * 100) + $last_count + 1;
                $dst = [$portweb, $portapi, $portwin];
                $jadi = $pecah_last_ip[0] . '.' . $pecah_last_ip[1] . '.' . $last_ip . '.' . $last_count + 1;
            }

            $username = generateUsername($request->input('username')) . $server->sufiks ?? '';
            $param =  [
                'user_id'   => $user->id,
                'server_id' => $request->input('server'),
                'username'  => $username,
                'password'  => $request->input('password'),
                'ip'        => $jadi,
                'expired'   => $exp,
                'is_active' => 'yes',
            ];
            $service = new ServerApiServices($server);
            $service->store($param, $dst);
            $vpn = Vpn::create($param);
            if ($temp) {
                $temp->delete();
            } else {
                $server->update([
                    'last_ip'   => $jadi,
                ]);
            }
            for ($i = 0; $i < count($dst); $i++) {
                Port::create([
                    'vpn_id'    => $vpn->id,
                    'dst'       => $dst[$i],
                    'to'        => $to[$i],
                ]);
            }
            DB::commit();
            return response()->json(['message' => 'Success Insert Data', 'data' => $vpn]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

   

    private function setServer(Vpn $vpn)
    {
        if (!$vpn->server->is_active === 'yes') {
            return response()->json(['message' => 'Server Nonactive!'], 403);
        }
        return new ServerApiServices($vpn->server);
    }

    public function sendEmail(Request $request, Vpn $vpn)
    {
        $this->validate($request, [
            'email' => 'required|email:rfc,dns'
        ]);
        $to = $request->email;
        try {
            Mail::to($to)->queue(new DetailVpnMail($vpn));
            $vpn->update(['last_email' => date('Y-m-d H:i:s')]);
            return response()->json(['message' => 'Success Send Email to ' . $to]);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Failed Send Email : ' . $th->getMessage()], 500);
        }
    }

    public function analyze(Request $request, Vpn $vpn)
    {
        try {
            $service = $this->setServer($vpn);
            $data = $service->analyze($vpn);
            return response()->json([
                'message' => '',
                'data' => [
                    'on_server' => $data,
                    'on_db'     => $vpn,
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Failed : ' . $th->getMessage(),
                'data' => [
                    'on_server' => null,
                    'on_db'     => $vpn,
                ]
            ], 500);
        }
    }

    public function download(Request $request, Vpn $vpn)
    {
        $path = storage_path('app/files/vpn');
        $file_name = generateUsername($vpn->username) . '.rsc';
        $content = "/interface sstp-client add";
        $content .= " connect-to=\"" . $vpn->server->domain . "\" ";
        $content .= " name=\"$vpn->username\" ";
        $content .= " user=\"$vpn->username\" ";
        $content .= " password=\"$vpn->username\" ";
        $content .= " disabled=\"no\" ";
        $content .= " comment=\"<<==" . $vpn->server->domain . "==>\"; ";
        $content .= " /tool netwatch add host=\"192.168.168.1\"  ";
        $content .= " comment=\"<<==" . $vpn->server->domain . "==>\"; ";
        if (!File::exists($path)) {
            File::makeDirectory($path, 755, true);
        }
        File::put($path . '/' . $file_name, $content);
        return response()->file($path . '/' . $file_name)->deleteFileAfterSend();
    }

    public function extend(Request $request, Vpn $vpn)
    {
        $this->validate($request, [
            'amount' => 'required|in:1,2,3,4,5,6,12'
        ]);
        $user = auth()->user();
        if ($user->is_not_admin() && $vpn->user_id != $user->id) {
            return response()->json(['message' => 'This not your VPN!'], 403);
        }
        DB::beginTransaction();
        try {
            $user_balance = $user->balance;
            $month = $request->amount;
            $amount = $month * 10000;
            if ($month == 12) {
                $amount = $amount - 20000;
            }
            if ($user_balance < $amount) {
                throw new Exception('Your Balance Not Enough, Please topup!');
            }
            $vpn_expired = $vpn->expired;
            $new_expired = date('Y-m-d', strtotime("+$month month", strtotime($vpn_expired)));
            if ($vpn->is_expired()) {
                $new_expired = date('Y-m-d', strtotime("+$month month", time()));
            }
            $service = $this->setServer($vpn);
            $service->extend($vpn, $new_expired);
            $vpn->update([
                'expired'   => $new_expired,
                'is_active' => 'yes',
            ]);
            $user->update([
                'balance' => $user_balance - $amount,
            ]);
            BalanceHistory::create([
                'date'      => date('Y-m-d H:i:s'),
                'user_id'   => $user->id,
                'amount'    => $amount,
                'type'      => 'min',
                'before'    => $user_balance,
                'after'     => $user_balance - $amount,
                'desc'      => 'Extend ' . $vpn->username . ' ' . $month . ' Month',
            ]);
            DB::commit();
            return response()->json(['message' => 'Success Extend Vpn']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => 'Failed Extend Vpn : ' . $th->getMessage()], 500);
        }
    }

    public function temporary(Request $request, Vpn $vpn)
    {
        DB::beginTransaction();
        try {
            $ports = $vpn->port;
            $count_port = count($ports ?? []);
            if ($count_port != 3) {
                throw new Exception('Vpn Not Suitable for move to temporary : port available ' . $count_port);
            }
            TemporaryIp::create([
                'server_id' => $vpn->server_id,
                'ip'        => $vpn->ip,
                'web'       => $ports[0]->dst,
                'api'       => $ports[1]->dst,
                'win'       => $ports[2]->dst,
            ]);
            $service = $this->setServer($vpn);
            $service->destroy($vpn);
            $vpn->delete();
            DB::commit();
            return response()->json(['message' => 'Success Move Vpn to Temporary!']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => 'Failed Move Vpn to Temporary : ' . $th->getMessage()], 500);
        }
    }
}
