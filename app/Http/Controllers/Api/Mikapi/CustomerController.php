<?php

namespace App\Http\Controllers\Api\Mikapi;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mikapi\CustomerResource;
use App\Models\Mikapi\Customer;
use App\Models\Mikapi\Odp;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Number;

class CustomerController extends Controller
{
    // 
    public function paginate(Request $request)
    {
        $limit = $this->get_limit($request);
        $filters = $filters = $request->only(['name', 'router_id', 'package_id', 'number_id', 'phone', 'email']);
        $filters['user_id'] = auth()->id();
        $data = Customer::query()->with(['package', 'odp'])->paginate($limit)->withQueryString();
        return CustomerResource::collection($data);
    }

    public function index(Request $request)
    {
        $filters = $filters = $request->only(['name', 'router_id', 'package_id', 'number_id', 'phone', 'email']);
        $filters['user_id'] = auth()->id();
        $query = Customer::query()->with(['package', 'odp'])->filter($filters);
        return DataTables::eloquent($query)->setTransformer(function ($item) {
            return CustomerResource::make($item)->resolve();
        })->toJson();
    }

    public function show(string $id)
    {
        $customer = $this->cek_exists($id);
        if (!$customer) {
            return $this->send_response_not_found();
        }
        // $customers_count = Customer::query()->filter([
        //     'odp_id' => $customer->odp_id,
        //     'user_id' => auth()->id()
        // ])->count();
        return new CustomerResource($customer->loadCount(['odp'])->load(['user', 'odp', 'package.router']));
        // $data = new CustomerResource($customer->loadCount(['odp'])->load(['user', 'odp', 'package.router']));
        // return  $data->additional(['data' => ['odp' => ['customers_count' => $customers_count]]]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $user_id = $user->id;
        $customer_count = $user->odps()->count();
        if ($customer_count >= 200) {
            return $this->send_response_unauthorize('Data Customer Limit 200!');
        }
        $this->validate($request, [
            'router' => [
                'required',
                Rule::exists('routers', 'id')->where('user_id', $user_id),
            ],
            'package' => [
                'required',
                Rule::exists('packages', 'id')->where('user_id', $user_id)->where('router_id', $request->router),
            ],
            'odp' => [
                'required',
                Rule::exists('odps', 'id')->where('user_id', $user_id)->where('router_id', $request->router),
            ],
            'name'              => 'required|min:3|max:30',
            'phone'             => 'required|min_digits:8|max_digits:15|numeric',
            'email'             => 'required|email:rfc,dns|min:1|max:50',
            'identity'          => 'nullable|max:50',
            'address'           => 'nullable|max:50',
            'regist'            => 'required|date_format:Y-m-d',
            'due'               => 'required|integer|min:0|max:31',
            'ip'                => 'nullable|ip|max:15',
            'mac'               => 'nullable|mac_address|max:20',
            'secret_username'   => 'nullable|max:50',
            'secret_password'   => 'nullable|max:50',
            'status'            => 'required|in:active,nonactive,suspended,blacklisted,pending',
            'lat'               => 'nullable|max:50',
            'long'              => 'nullable|max:50',
        ]);
        $odp = Odp::query()->withCount('customers')->where('user_id', $user_id)->where('router_id', $request->router)->find($request->odp);

        if ($odp->customers_count >= $odp->max_port) {
            return $this->send_response_unauthorize('ODP ' . $odp->name . ' PORT FULL!');
        }

        $number_id = Str::random(10);
        $customer = Customer::create([
            'number_id'         => $number_id,
            'user_id'           => $user_id,
            'package_id'        => $request->package,
            'odp_id'            => $request->odp,
            'name'              => $request->name,
            'phone'             => $request->phone,
            'email'             => $request->email,
            'identity'          => $request->identity,
            'address'           => $request->address,
            'regist'            => $request->regist,
            'due'               => $request->due,
            'ip'                => $request->ip,
            'mac'               => $request->mac,
            'lat'               => $request->lat,
            'long'              => $request->long,
            'secret_username'   => $request->secret_username,
            'secret_password'   => $request->secret_password,
            'status'            => $request->status,
        ]);
        return $this->send_response('Customer Created!');
    }

    public function update(Request $request, string $id)
    {
        $customer = $this->cek_exists($id);
        if (!$customer) {
            return $this->send_response_not_found();
        }
        $user_id = auth()->id();
        $this->validate($request, [
            'router' => [
                'required',
                Rule::exists('routers', 'id')->where('user_id', $user_id),
            ],
            'package' => [
                'required',
                Rule::exists('packages', 'id')->where('user_id', $user_id)->where('router_id', $request->router),
            ],
            'odp' => [
                'required',
                Rule::exists('odps', 'id')->where('user_id', $user_id)->where('router_id', $request->router),
            ],
            'name'              => 'required|min:3|max:30',
            'phone'             => 'required|min_digits:8|max_digits:15|numeric',
            'email'             => 'required|email:rfc,dns|min:1|max:50',
            'identity'          => 'nullable|max:50',
            'address'           => 'nullable|max:50',
            'regist'            => 'required|date_format:Y-m-d',
            'due'               => 'required|integer|min:0|max:31',
            'ip'                => 'nullable|ip|max:15',
            'mac'               => 'nullable|mac_address|max:20',
            'secret_username'   => 'nullable|max:50',
            'secret_password'   => 'nullable|max:50',
            'status'            => 'required|in:active,nonactive,suspended,blacklisted,pending',
            'lat'               => 'nullable|max:50',
            'long'              => 'nullable|max:50',
        ]);

        $new_odp = Odp::query()->withCount('customers')->find($request->odp);

        $max_port = $new_odp->max_port;
        $customers_count = $new_odp->customers_count;
        if ($customer->odp_id == $new_odp->id) {
            $customers_count -= 1;
        }
        if ($customers_count >= $max_port) {
            return $this->send_response_unauthorize('ODP ' . $new_odp->name . ' PORT FULL!');
        }

        $customer->update([
            'user_id'           => $user_id,
            'package_id'        => $request->package,
            'odp_id'            => $request->odp,
            'name'              => $request->name,
            'phone'             => $request->phone,
            'email'             => $request->email,
            'identity'          => $request->identity,
            'address'           => $request->address,
            'regist'            => $request->regist,
            'due'               => $request->due,
            'ip'                => $request->ip,
            'mac'               => $request->mac,
            'lat'               => $request->lat,
            'long'              => $request->long,
            'secret_username'   => $request->secret_username,
            'secret_password'   => $request->secret_password,
            'status'            => $request->status,
        ]);
        return $this->send_response('Customer Updated!');
    }

    public function destroy(string $id)
    {
        $customer = $this->cek_exists($id);
        if (!$customer) {
            return $this->send_response_not_found();
        }
        $customer->delete();
        return $this->send_response('Customer Deleted!');
    }

    public function destroyBatch(Request $request)
    {
        $this->validate($request, [
            'id'        => 'required|array|min:1',
            'id.*'      => 'integer|exists:customers,id',
        ]);
        $ids = $request->id;
        $deleted = Customer::whereIn('id', $ids)->where('user_id', auth()->id())->delete();
        $message = 'Success Delete : ' . $deleted . ' & Fail : ' . (count($request->id) - $deleted);
        return $this->send_response($message);
    }


    private function cek_exists(string $id)
    {
        $filters['user_id'] = auth()->id();
        $customer = Customer::query()->filter($filters)->find($id);
        return $customer;
    }
}
