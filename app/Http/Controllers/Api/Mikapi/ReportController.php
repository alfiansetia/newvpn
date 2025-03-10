<?php

namespace App\Http\Controllers\Api\Mikapi;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mikapi\ReportResource;
use App\Services\Mikapi\ReportServices;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('router.exists');
    }

    public function index(Request $request)
    {
        try {
            $date = $request->date;
            $month = $request->month;
            $year = $request->year;

            if (empty($date)) {
                $data = ReportServices::routerId($request->router)->getByMonth("$month$year");
            } else {
                $data = ReportServices::routerId($request->router)->getByDay("$month/$date/$year");
            }
            return DataTables::collection($data)->setTransformer(function ($item) {
                return ReportResource::make($item)->resolve();
            })->toJson();
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function show(Request $request, string $id)
    {
        try {
            $data = ReportServices::routerId($request->router)->show($id);
            return new ReportResource($data);
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function destroy(Request $request, string $id)
    {
        try {
            $data = ReportServices::routerId($request->router)->destroy([$id]);
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
        $id = $request->id;
        try {
            $data = ReportServices::routerId($request->router)->destroy($id);
            return $this->send_response('Success Delete Data!');
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function summary(Request $request)
    {
        try {
            $date = date('d');
            $month = strtolower(date('M'));
            $year = date('Y');
            $today_service = ReportServices::routerId($request->router)->getByDay("$month/$date/$year");
            $month_service = ReportServices::routerId($request->router)->getByMonth("$month$year");
            $today_data = collect(ReportResource::collection($today_service)->toArray($request));
            $month_data = collect(ReportResource::collection($month_service)->toArray($request));
            return response()->json([
                'data' => [
                    'today' => [
                        'vc'    => $today_data->count(),
                        'total' => $today_data->sum('price')
                    ],
                    'month' => [
                        'vc'    => $month_data->count(),
                        'total' => $month_data->sum('price')
                    ]
                ]
            ]);
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }
}
