<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VoucherTemplateResource;
use App\Models\VoucherTemplate;
use Illuminate\Http\Request;

class VoucherTemplateController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:admin')->except(['index']);
    }

    public function index()
    {
        $data = VoucherTemplate::all();
        return response()->json([
            'message' => '',
            'data' => VoucherTemplateResource::collection($data)
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required|max:200',
            'html_up'   => 'required|max:65535',
            'html_vc'   => 'required|max:65535',
        ]);
        $vc = VoucherTemplate::create([
            'name'      => $request->name,
            'html_up'   => $request->html_up,
            'html_vc'   => $request->html_vc,
        ]);
        return response()->json(['message' => 'Success Insert Data!', 'data' => $vc]);
    }

    public function update(Request $request, VoucherTemplate $voucher)
    {
        $this->validate($request, [
            'name'      => 'required|max:200',
            'html_up'   => 'required|max:65535',
            'html_vc'   => 'required|max:65535',
        ]);
        $voucher->update([
            'name'      => $request->name,
            'html_up'   => $request->html_up,
            'html_vc'   => $request->html_vc,
        ]);
        return response()->json(['message' => 'Success Update Data!', 'data' => $voucher]);
    }
}
