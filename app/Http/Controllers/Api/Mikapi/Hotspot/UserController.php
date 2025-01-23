<?php

namespace App\Http\Controllers\Api\Mikapi\Hotspot;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mikapi\Hotspot\UserResource;
use App\Services\Mikapi\GenerateRandom;
use App\Services\Mikapi\Hotspot\UserServices;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('router.exists');
    }

    public function index(Request $request)
    {
        try {
            $response = UserServices::routerId($request->router)->from_cache();
            $data = collect($response);
            if ($request->filled('comment')) {
                $data = $data->where('comment', $request->comment);
            }
            if ($request->filled('profile')) {
                $data = $data->where('profile', $request->profile);
            }
            return DataTables::collection($data)->setTransformer(function ($item) {
                return UserResource::make($item)->resolve();
            })->toJson();
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function comment(Request $request)
    {
        try {
            $service = new UserServices();
            $response = $service->routerId($request->router)->from_cache();
            // $data = collect($response)->unique('comment');
            $data = collect($response)
                ->groupBy('comment')
                ->map(function ($items, $key) {
                    $item = $items->first();
                    $item['count'] = $items->count();
                    return $item;
                })->values();
            return $this->send_response('', $data);
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    private function refreshData(Request $request)
    {
        $data = UserServices::routerId($request->router)->cache(true)->get();
        return $data;
    }

    public function refresh(Request $request)
    {
        try {
            $data  = $this->refreshData($request);
            return $this->send_response('Success Refresh Data!');
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function show(Request $request, string $id)
    {
        try {
            $data = UserServices::routerId($request->router)->show($id);
            return new UserResource($data);
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'server'        => 'required',
            'profile'       => 'required',
            'name'          => 'required|min:2|max:50',
            'password'      => 'nullable|max:50',
            'ip_address'    => 'nullable|ip',
            'mac'           => 'nullable|mac_address',
            'data_day'      => 'nullable|integer|between:0,365',
            'time_limit'    => 'required|date_format:H:i:s',
            'data_limit'    => 'required|integer|gte:0',
            'data_type'     => 'nullable|in:K,M,G',
            'comment'       => 'nullable|max:100',
            'is_active'     => 'nullable|in:on',
        ]);
        $param = [
            'server'             => $request->input('server'),
            'profile'            => $request->input('profile'),
            'name'               => $request->input('name'),
            'password'           => $request->input('password'),
            'address'            => $request->input('ip_address') ?? '0.0.0.0',
            'mac-address'        => $request->input('mac') ?? '00:00:00:00:00:00',
            'limit-uptime'       => ($request->data_day ?? 0) . 'd ' . $request->time_limit,
            'limit-bytes-total'  => $request->data_limit . ($request->data_type ?? 'K'),
            'comment'            => $request->input('comment'),
            'disabled'           => $request->input('is_active') == 'on' ? 'no' : 'yes',
        ];
        try {
            $data = UserServices::routerId($request->router)->store($param);
            return $this->send_response('Success Insert Data!', $data);
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'server'        => 'nullable',
            'profile'       => 'required',
            'name'          => 'required|min:2|max:50',
            'password'      => 'nullable|max:50',
            'ip_address'    => 'nullable|ip',
            'mac'           => 'nullable|mac_address',
            'data_day'      => 'required|integer|between:0,365',
            'time_limit'    => 'required|date_format:H:i:s',
            'data_limit'    => 'required|integer|gte:0',
            'data_type'     => 'required|in:K,M,G',
            'comment'       => 'nullable|max:100',
            'is_active'     => 'nullable|in:on',
        ]);
        $param = [
            // '.id'                => $id,
            'server'             => $request->input('server') ?? 'all',
            'profile'            => $request->input('profile'),
            'name'               => $request->input('name'),
            'password'           => $request->input('password'),
            'address'            => $request->input('ip_address') ?? '0.0.0.0',
            'mac-address'        => $request->input('mac') ?? '00:00:00:00:00:00',
            'limit-uptime'       => ($request->data_day ?? 0) . 'd ' . $request->time_limit,
            'limit-bytes-total'  => $request->data_limit . $request->data_type,
            'comment'            => $request->input('comment'),
            'disabled'           => $request->input('is_active') == 'on' ? 'no' : 'yes',
        ];
        try {
            $data = UserServices::routerId($request->router)->update($id, $param);
            return $this->send_response('Success Update Data!', $data);
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function destroy(Request $request, string $id)
    {
        try {
            $data = UserServices::routerId($request->router)->destroy([$id]);
            return $this->send_response('Success Delete Data!');
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function destroy_batch(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|array|min:1|max:1000'
        ]);
        $ids = $request->id;
        try {
            $data = UserServices::routerId($request->router)->destroy($ids);
            return $this->send_response('Success Delete Data!');
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }


    public function generate(Request $request)
    {
        $this->validate($request, [
            'qty'           => 'required|integer|gte:1|lte:500',
            'server'        => 'required',
            'user_mode'     => 'required|in:up,vc',
            'length'        => 'required|integer|gte:3|lte:8',
            'prefix'        => 'nullable|alpha_num|max:6',
            'character'     => 'required|in:num,up,low,uplow,numlow,numup,numlowup',
            'profile'       => 'required',
            'data_day'      => 'nullable|integer|between:0,365',
            'time_limit'    => 'required|date_format:H:i:s',
            'data_limit'    => 'required|integer|gte:0',
            'data_type'     => 'nullable|in:K,M,G',
            'comment'       => 'nullable|max:100|alpha_num',
        ]);

        try {
            $data = UserServices::routerId($request->router)->generate($request);
            return $this->send_response('Success Generate Data!', $data);
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }
}
