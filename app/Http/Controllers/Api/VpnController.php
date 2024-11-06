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
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class VpnController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
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
            return $this->send_error('Error : ' . $th->getMessage());
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
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function destroyBatch(Request $request)
    {
        return $this->send_error('This Feature not available this time!');
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
            return $this->send_error('Error : ' . $th->getMessage());
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
}
