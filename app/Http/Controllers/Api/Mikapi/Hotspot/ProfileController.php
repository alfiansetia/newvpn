<?php

namespace App\Http\Controllers\Api\Mikapi\Hotspot;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mikapi\Hotspot\ProfileResource;
use App\Services\Mikapi\Hotspot\ProfileServices;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProfileController extends Controller
{

    public function __construct(Request $request)
    {
        $this->middleware('router.exists');
    }

    public function index(Request $request)
    {
        try {
            $filters = $request->only(['name']);
            $data = ProfileServices::routerId($request->router)->get($filters);
            return DataTables::collection($data)->setTransformer(function ($item) {
                return ProfileResource::make($item)->resolve();
            })->toJson();
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function show(Request $request, string $id)
    {
        try {
            $data = ProfileServices::routerId($request->router)->show($id);
            return new ProfileResource($data);
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'              => 'required|min:1|max:50',
            'shared_users'      => 'integer|gte:0',
            'rate_limit'        => 'nullable|min:5|max:25',
            'parent'            => 'required',
            'pool'              => 'required',
            'price'             => 'required|integer|gte:0',
            'selling_price'     => 'required|integer|gte:0',
            'expired_mode'      => 'required|in:0,rem,ntf,remc,ntfc',
            'lock_user'         => 'required|in:Enable,Disable',
            'data_day'          => 'nullable|integer|between:0,365',
            'time_limit'        => 'nullable|date_format:H:i:s',
        ]);
        $expmode = $request->expired_mode;
        $day = $request->data_day;
        $time = parse_dtm_to_string($request->time_limit ?? '00:00:00');
        if ($expmode != 0) {
            if ($day < 1 && empty($time)) {
                return response()->json([
                    'message' => "Validity Required When Expired Mode not None!",
                    'errors' => [
                        'data_day'      => ['Day/Time Limit Required'],
                        'time_limit'    => ['Day/Time Limit Required'],
                    ]
                ], 422);
            }
        }

        try {
            $data = ProfileServices::routerId($request->router)->store($request);
            return $this->send_response('Success Insert Data!');
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name'              => 'required|min:1|max:50',
            'shared_users'      => 'integer|gte:0',
            'rate_limit'        => 'nullable|min:5|max:25',
            'parent'            => 'required',
            'pool'              => 'required',
            'price'             => 'required|integer|gte:0',
            'selling_price'     => 'required|integer|gte:0',
            'expired_mode'      => 'required|in:0,rem,ntf,remc,ntfc',
            'lock_user'         => 'required|in:Enable,Disable',
            'data_day'          => 'nullable|integer|between:0,365',
            'time_limit'        => 'nullable|date_format:H:i:s',
        ]);
        $expmode = $request->expired_mode;
        $day = $request->data_day;
        $time = parse_dtm_to_string($request->time_limit ?? '00:00:00');
        if ($expmode != 0) {
            if ($day < 1 && empty($time)) {
                return response()->json([
                    'message' => "Validity Required When Expired Mode not None!",
                    'errors' => [
                        'data_day'      => ['Day/Time Limit Required'],
                        'time_limit'    => ['Day/Time Limit Required'],
                    ]
                ], 422);
            }
        }
        try {
            $data = ProfileServices::routerId($request->router)->update($id, $request);
            return $this->send_response('Success Update Data!');
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function destroy(Request $request, string $id)
    {
        try {
            $data = ProfileServices::routerId($request->router)->destroy([$id]);
            return $this->send_response('Success Delete Data, Delete Manually Scheduler!');
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function destroy_batch(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|array|min:1|max:1000'
        ]);
        $id = $request->id;
        try {
            $data = ProfileServices::routerId($request->router)->destroy($id);
            return $this->send_response('Success Delete Data, Delete Manually Scheduler!!');
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }
}
