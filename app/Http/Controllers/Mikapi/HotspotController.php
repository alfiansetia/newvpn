<?php

namespace App\Http\Controllers\Mikapi;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mikapi\Hotspot\ProfileResource;
use App\Http\Resources\Mikapi\Hotspot\UserResource;
use App\Http\Resources\VoucherTemplateResource;
use App\Models\VoucherTemplate;
use App\Services\Mikapi\Hotspot\ProfileServices;
use App\Services\Mikapi\Hotspot\UserServices;
use Illuminate\Http\Request;

class HotspotController extends Controller
{

    public function __construct()
    {
        $this->middleware('router.exists');
    }

    public function server()
    {
        return view('mikapi.hotspot.server.index');
    }

    public function profile()
    {
        return view('mikapi.hotspot.profile.index');
    }

    public function user()
    {
        return view('mikapi.hotspot.user.index');
    }

    public function user_generate()
    {
        return view('mikapi.hotspot.user.generate');
    }

    public function active()
    {
        return view('mikapi.hotspot.active.index');
    }

    public function host()
    {
        return view('mikapi.hotspot.host.index');
    }

    public function binding()
    {
        return view('mikapi.hotspot.binding.index');
    }

    public function cookie()
    {
        return view('mikapi.hotspot.cookie.index');
    }

    public function voucher(Request $request, string $id)
    {
        $t = VoucherTemplate::find($id);
        if (!$t) {
            abort(404);
        }
        $template = new VoucherTemplateResource($t);
        $services = UserServices::routerId($request->router)->cache(true);
        $profile_data = ProfileServices::routerId($request->router)->get();
        $profiles = ProfileResource::collection($profile_data)->toArray($request);
        $router = $services->get_router();
        $cache = $services->from_cache();
        $data = collect($cache);
        if ($request->filled('comment')) {
            $data = $data->where('comment', $request->comment);
        }
        $mode = $request->mode;
        $price = $request->price ?? 0;
        $data = UserResource::collection($data)->toArray($request);
        return view('mikapi.hotspot.user.voucher', compact('data', 'router', 'template', 'mode', 'price', 'profiles'));
    }
}
