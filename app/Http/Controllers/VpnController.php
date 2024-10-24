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
        return view('vpn.create_auto');
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
