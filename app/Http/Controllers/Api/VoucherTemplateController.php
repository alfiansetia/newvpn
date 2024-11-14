<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VoucherTemplateResource;
use App\Models\VoucherTemplate;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VoucherTemplateController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin')->except(['index', 'paginate']);
    }

    public function paginate(Request $request)
    {
        $limit = $this->get_limit($request);
        $filters = $request->only(['name']);
        $data = VoucherTemplate::query()->filter($filters)->paginate($limit)->withQueryString();
        return VoucherTemplateResource::collection($data);
    }

    public function index(Request $request)
    {
        $filters = $request->only(['name']);
        $query = VoucherTemplate::query()->filter($filters);
        return DataTables::eloquent($query)->setTransformer(function ($item) {
            return VoucherTemplateResource::make($item)->resolve();
        })->toJson();
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
        return $this->send_response('Success Insert Data!');
    }

    public function show(VoucherTemplate $voucher)
    {
        return new VoucherTemplateResource($voucher);
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
        return $this->send_response('Success Update Data!');
    }

    public function destroy(VoucherTemplate $voucher)
    {
        $voucher->delete();
        return $this->send_response('Success Delete Data');
    }

    public function destroyBatch(Request $request)
    {
        $this->validate($request, [
            'id'        => 'required|array|min:1',
            'id.*'      => 'integer|exists:voucher_templates,id',
        ]);
        $ids = $request->id;
        $deleted = VoucherTemplate::whereIn('id', $ids)->delete();
        $message = 'Success Delete : ' . $deleted . ' & Fail : ' . (count($request->id) - $deleted);
        return $this->send_response($message);
    }
}
