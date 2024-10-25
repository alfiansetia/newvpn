<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VpnResource;
use App\Mail\DetailVpnMail;
use App\Models\BalanceHistory;
use App\Models\Port;
use App\Models\Server;
use App\Models\TemporaryIp;
use App\Models\Vpn;
use App\Services\VpnServices;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class VpnController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin')->except(['paginateUser']);
    }

    public function paginateUser(Request $request)
    {
        $limit = $this->get_limit($request);
        $filters = $request->only(['username', 'ip', 'server_id', 'is_active', 'is_trial', 'dst']);
        $filters['user_id'] = auth()->id();
        $data = Vpn::query()->with(['user', 'server'])->filter($filters)->paginate($limit)->withQueryString();
        return VpnResource::collection($data);
    }

    public function paginate(Request $request)
    {
        $limit = $this->get_limit($request);
        $filters = $request->only(['username', 'ip', 'server_id', 'is_active', 'is_trial', 'dst', 'user_id']);
        $data = Vpn::query()->with(['user', 'server'])->filter($filters)->paginate($limit)->withQueryString();
        return VpnResource::collection($data);
    }

    public function index(Request $request)
    {
        $filters = $filters = $request->only(['username', 'ip', 'server_id', 'is_active', 'is_trial', 'dst', 'user_id']);
        $query = Vpn::query()->with(['user', 'server'])->filter($filters);
        return DataTables::eloquent($query)->setTransformer(function ($item) {
            return VpnResource::make($item)->resolve();
        })->toJson();
    }

    public function show(Vpn $vpn)
    {
        return new VpnResource($vpn->load(['user', 'server', 'ports']));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email'     => 'required|integer|exists:users,id',
            'server'    => 'required|integer|exists:servers,id',
            'username'  => 'required|max:50|min:4|unique:vpns,username,' . $request->input('username') . ',id,server_id,' . $request->input('server'),
            'password'  => 'required|max:50|min:4',
            'ip'        => 'required|ip|unique:vpns,ip,' . $request->input('ip') . ',id,server_id,' . $request->input('server'),
            'expired'   => 'required|date_format:Y-m-d',
            'is_active' => 'nullable|in:on',
            'is_trial'  => 'nullable|in:on',
            'sync'      => 'nullable|in:on',
            'desc'      => 'nullable|max:200',
        ]);
        $server = Server::where('is_active', 1)->find($request->input('server'));
        if (!$server) {
            return $this->send_response_unauthorize('The selected server is not active.');
        }
        DB::beginTransaction();
        try {
            $expired = Carbon::parse($request->expired)->format('Y-m-d');
            $vpn = Vpn::create([
                'user_id'   => $request->input('email'),
                'server_id' => $request->input('server'),
                'username'  => $request->input('username'),
                'password'  => $request->input('password'),
                'ip'        => $request->input('ip'),
                'expired'   => $expired,
                'is_active' => $request->input('is_active') == 'on',
                'is_trial'  => $request->input('is_trial') == 'on',
                'desc'      => $request->input('desc'),
            ]);
            if ($request->sync == 'on') {
                $service = VpnServices::server($server)->store($vpn);
            }
            DB::commit();
            return $this->send_response('Success Insert Data');
        } catch (Throwable $th) {
            DB::rollBack();
            return $this->send_error($th->getMessage());
        }
    }

    public function update(Request $request, Vpn $vpn)
    {
        $this->validate($request, [
            'email'         => 'required|integer|exists:users,id',
            'username'      => 'required|max:50|min:4|unique:vpns,username,' . $vpn->id . ',id,server_id,' . $vpn->server_id,
            'password'      => 'required|max:50|min:4',
            'ip'            => 'required|ip|unique:vpns,ip,' . $vpn->id . ',id,server_id,' . $vpn->server_id,
            'expired'       => 'required|date_format:Y-m-d',
            'is_active'     => 'nullable|in:on',
            'is_trial'      => 'nullable|in:on',
            'sync'          => 'nullable|in:on',
            'desc'          => 'nullable|max:200',
        ]);
        $expired = $request->input('expired');
        try {
            $old = $vpn->load(['server', 'ports'])->toArray();
            $param = [
                'user_id'   => $request->input('email'),
                'username'  => $request->input('username'),
                'password'  => $request->input('password'),
                'ip'        => $request->input('ip'),
                'expired'   => $expired,
                'is_active' => $request->input('is_active') == 'on',
                'is_trial'  => $request->input('is_trial') == 'on',
                'desc'      => $request->input('desc'),
            ];
            $vpn->update($param);
            $new = $vpn->fresh()->load(['server', 'ports']);
            if ($request->sync == 'on') {
                $service = VpnServices::server($vpn->server)->update($old, $new);
            }
            return response()->json(['message' => 'Success Update Data', 'data' => '']);
        } catch (Throwable $e) {
            return response()->json(['message' => 'Failed Update Data : ' . $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request, Vpn $vpn)
    {
        DB::beginTransaction();
        try {
            $service  = VpnServices::server($vpn->server)->destroy($vpn);
            $vpn->delete();
            DB::commit();
            return $this->send_response('Success Delete Data!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->send_error($th->getMessage());
        }
    }

    public function destroyBatch(Request $request)
    {
        return $this->send_error('This Feature not available this time!');
    }

    public  function autoCreate(Request $request)
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
            $total = $server->annual_price * $qty;
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
                    'desc'      => 'Order ' . $vpn->username . ' ' . $qty . ' Month',
                ]);
            }
            $service = VpnServices::server($server)->store($vpn->fresh());
            DB::commit();
            return $this->send_response('Success Create VPN!');
        } catch (Throwable $th) {
            DB::rollBack();
            return $this->send_error($th->getMessage());
        }
    }

    public function temporary(Request $request, Vpn $vpn)
    {
        $vpn->load(['ports', 'server']);
        $ports = $vpn->ports;
        $count_port = count($ports ?? []);
        if ($count_port != 3) {
            return $this->send_response_unauthorize('Vpn Not Suitable for move to temporary : port available ' . $count_port);
        }
        DB::beginTransaction();
        try {
            TemporaryIp::create([
                'server_id' => $vpn->server_id,
                'ip'        => $vpn->ip,
                'web'       => $ports[0]->dst,
                'api'       => $ports[1]->dst,
                'win'       => $ports[2]->dst,
            ]);
            $service = VpnServices::server($vpn->server)->destroy($vpn);
            $vpn->delete();
            DB::commit();
            return $this->send_response('Success Move Vpn to Temporary!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->send_error($th->getMessage());
        }
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
            return $this->send_response('Success Send Email to ' . $to);
        } catch (\Throwable $th) {
            return $this->send_error('Failed Send Email : ' . $th->getMessage());
        }
    }

    public function extend(Request $request, Vpn $vpn)
    {
        $this->validate($request, [
            'amount' => 'required|in:1,2,3,4,5,6,12'
        ]);
        $user = auth()->user();
        if (!$user->is_admin() && $vpn->user_id != $user->id) {
            return $this->send_response_unauthorize('This not your VPN!');
        }
        $vpn->load(['server', 'ports']);
        $server = $vpn->server;
        $user_balance = $user->balance;
        $month = $request->amount;
        $amount = $server->price * $month;
        if ($month == 12) {
            $amount = $server->annual_price * $amount;
        }
        if ($user_balance < $amount) {
            return $this->send_response_unauthorize('Your Balance Not Enough, Please topup!');
        }
        DB::beginTransaction();
        try {
            $vpn_expired = $vpn->expired;

            $new_expired = Carbon::parse($vpn_expired)->addMonths($month)->format('Y-m-d');
            if ($vpn->is_expired()) {
                $new_expired = Carbon::now()->addMonths($month)->format('Y-m-d');
            }
            $old = $vpn->toArray();
            $vpn->update([
                'expired'       => $new_expired,
                'is_active'     => 1,
                'is_trial'      => 0,
                'last_renew'    => date('Y-m-d H:i:s'),
            ]);
            $new = $vpn->fresh();
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
                'desc'      => 'Extend ' . $vpn->username . ' ' . $month . ' Month',
            ]);
            DB::commit();
            return $this->send_response('Success Extend Vpn ' . $month . ' Month!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->send_error('Failed Extend Vpn : ' . $th->getMessage());
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
}
