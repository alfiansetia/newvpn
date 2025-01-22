<?php

namespace App\Http\Controllers\Mikapi;

use App\Http\Controllers\Controller;
use App\Models\VoucherTemplate;
use Illuminate\Http\Request;

class VoucherTemplateController extends Controller
{
    public function index(Request $request)
    {
        $data = VoucherTemplate::all();
        return view('mikapi.voucher_template', compact('data'));
    }

    public function show(VoucherTemplate $template)
    {
        $data = $template;
        return view('template.preview', compact('data'));
    }
}
