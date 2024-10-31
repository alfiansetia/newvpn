<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VpnResource;
use App\Mail\DetailVpnMail;
use App\Models\BalanceHistory;
use App\Models\Server;
use App\Models\TemporaryIp;
use App\Models\Vpn;
use App\Services\VpnServices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class VpnUserController extends Controller
{

    public function paginate(Request $request)
    {
        $limit = $this->get_limit($request);
        $filters = $request->only(['username', 'ip', 'server_id', 'is_active', 'is_trial', 'dst']);
        $filters['user_id'] = auth()->id();
        $data = Vpn::query()->with(['user', 'server'])->filter($filters)->paginate($limit)->withQueryString();
        return VpnResource::collection($data);
    }

    public function index(Request $request)
    {
        $filters = $filters = $request->only(['username', 'ip', 'server_id', 'is_active', 'is_trial', 'dst', 'user_id']);
        $filters['user_id'] = auth()->id();
        $query = Vpn::query()->with(['user', 'server'])->filter($filters);
        return DataTables::eloquent($query)->setTransformer(function ($item) {
            return VpnResource::make($item)->resolve();
        })->toJson();
    }

    public function show(Vpn $vpn_user)
    {
        if ($vpn_user->user_id != auth()->id()) {
            return $this->send_response_not_found();
        }
        return new VpnResource($vpn_user->load(['user', 'server', 'ports']));
    }

    public  function store(Request $request)
    {
        $user = auth()->user();
        $this->validate($request, [
            'server'    => [
                'required',
                'integer',
                Rule::exists('servers', 'id')->where(function ($query) {
                    $query->where('is_active', 1)->where('is_available', 1);
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
                            $fail('Username not available!');
                        }
                    }
                },
            ],
            'password'  => 'required|string|max:50|min:4',
            'qty'       => 'required|integer|in:0,1,2,3,4,5,6,12'
        ]);
        $server = Server::find($request->input('server'));
        $qty = $request->qty;
        $user_balance = $user->balance;
        if ($qty == 0) {
            $total = 0;
            if ($user->is_admin()) {
                $count_trial = 0;
            } else {
                $count_trial = Vpn::where('user_id', '=', $user->id)->where('is_trial', 1)->count();
            }
            if ($count_trial > 0) {
                return $this->send_response_unauthorize('Trial Sudah Ada, Silahkan Selesaikan Pembayaran Dahulu Untuk membuat Trial Lagi!');
            }
        } elseif ($qty == 12) {
            $total = $server->annual_price;
        } else {
            $total = $server->price * $qty;
        }
        if ($user_balance < $total) {
            return $this->send_response_unauthorize('Balance not Enough! Please Top Up!');
        }
        $reg = Carbon::now();
        if ($qty == 0) {
            $exp = $reg->copy()->addDay()->format('Y-m-d');
        } else {
            $exp = $reg->copy()->addMonths(intval($qty))->format('Y-m-d');
        }
        $temp = TemporaryIp::where('server_id', $server->id)->first();
        DB::beginTransaction();
        try {
            $netw = $server->netwatch;
            if ($temp) {
                $jadi = $temp->ip;
                $ports = [
                    [
                        'dst' => $temp->web,
                        'to' => 80
                    ],
                    [
                        'dst' => $temp->api,
                        'to' => 8728
                    ],
                    [
                        'dst' => $temp->win,
                        'to' => 8291
                    ]
                ];
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
                $ports = [
                    [
                        'dst' => $portweb,
                        'to' => 80
                    ],
                    [
                        'dst' => $portapi,
                        'to' => 8728
                    ],
                    [
                        'dst' => $portwin,
                        'to' => 8291
                    ]
                ];
                $jadi = $pecah_last_ip[0] . '.' . $pecah_last_ip[1] . '.' . $last_ip . '.' . $last_count + 1;
            }

            $username = generateUsername($request->input('username')) . $server->sufiks ?? '';
            $vpn = Vpn::create([
                'user_id'   => $user->id,
                'server_id' => $request->input('server'),
                'username'  => $username,
                'password'  => $request->input('password'),
                'ip'        => $jadi,
                'expired'   => $exp,
                'is_active' => 1,
                'is_trial'  => intval($qty) == 0,
            ]);
            if ($temp) {
                $temp->delete();
            } else {
                $server->update([
                    'last_ip'   => $jadi,
                ]);
            }
            $vpn->ports()->createMany($ports);
            if ($total > 0) {
                $user->update([
                    'balance' => $user_balance  - $total,
                ]);
                BalanceHistory::create([
                    'date'      => date('Y-m-d H:i:s'),
                    'user_id'   => $user->id,
                    'amount'    => $total,
                    'type'      => 'min',
                    'before'    => $user_balance,
                    'after'     => $user_balance - $total,
                    'desc'      => 'Order VPN ' . $vpn->username . ' ' . $qty . ' Month',
                ]);
            }
            $service = VpnServices::server($server)->store($vpn->fresh());
            Mail::to($user->email)->queue(new DetailVpnMail($vpn));

            DB::commit();
            return $this->send_response('Success Create VPN!');
        } catch (Throwable $th) {
            DB::rollBack();
            return $this->send_error($th->getMessage());
        }
    }

    public function update(Request $request, Vpn $vpn_user)
    {
        $this->validate($request, [
            'amount' => 'required|in:1,2,3,4,5,6,12'
        ]);
        $user = auth()->user();
        if ($vpn_user->user_id != $user->id) {
            return $this->send_response_not_found();
        }
        $vpn_user->load(['server', 'ports']);
        $server = $vpn_user->server;
        $user_balance = $user->balance;
        $month = $request->amount;
        $int_month = intval($month);
        $amount = $server->price * $month;
        if ($month == 12) {
            $amount = $server->annual_price * $amount;
        }
        if ($user_balance < $amount) {
            return $this->send_response_unauthorize('Your Balance Not Enough, Please topup!');
        }
        DB::beginTransaction();
        try {
            $vpn_expired = $vpn_user->expired;

            $new_expired = Carbon::parse($vpn_expired)->addMonths($int_month)->format('Y-m-d');
            if ($vpn_user->is_expired()) {
                $new_expired = Carbon::now()->addMonths($int_month)->format('Y-m-d');
            }
            $old = $vpn_user->toArray();
            $vpn_user->update([
                'expired'       => $new_expired,
                'is_active'     => 1,
                'is_trial'      => 0,
                'last_renew'    => date('Y-m-d H:i:s'),
            ]);
            $new = $vpn_user->fresh();
            $service = VpnServices::server($server)->update($old, $new);
            $new_balance =  $user_balance - $amount;
            $user->update([
                'balance' => $new_balance,
            ]);
            BalanceHistory::create([
                'date'      => date('Y-m-d H:i:s'),
                'user_id'   => $user->id,
                'amount'    => $amount,
                'type'      => 'min',
                'before'    => $user_balance,
                'after'     => $new_balance,
                'desc'      => 'Extend VPN ' . $vpn_user->username . ' ' . $month . ' Month',
            ]);
            Mail::to($user->email)->queue(new DetailVpnMail($vpn_user));
            DB::commit();
            return $this->send_response('Success Extend Vpn ' . $month . ' Month!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->send_error('Failed Extend Vpn : ' . $th->getMessage());
        }
    }
}
