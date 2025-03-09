<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WhatsappTokenResource;
use App\Models\WhatsappToken;
use App\Services\Whatsapp\FonnteServices;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class WhatsappTokenController extends Controller
{
    public function paginate(Request $request)
    {
        $limit = $this->get_limit($request);
        $filters = $request->only(['from']);
        $filters['user_id'] = auth()->id();
        $data = WhatsappToken::query()->filter($filters)->paginate($limit)->withQueryString();
        return WhatsappTokenResource::collection($data);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $filters = $request->only(['from']);
        $filters['user_id'] = auth()->id();
        $query = WhatsappToken::query()->filter($filters);
        return DataTables::eloquent($query)->setTransformer(function ($item) {
            return WhatsappTokenResource::make($item)->resolve();
        })->toJson();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id = auth()->id();
        $token_count = WhatsappToken::query()->where('user_id', $user_id)->count();
        if ($token_count >= 3) {
            return $this->send_response_unauthorize('Limit Token : 3 Per User!');
        }
        $this->validate($request, [
            'value' => 'required|max:100',
            'from'  => 'required|in:FONNTE',
            'desc'  => 'nullable|max:100',
        ]);
        $token_exist = WhatsappToken::query()->where('user_id', $user_id)
            ->where('value', $request->value)->first();
        if ($token_exist) {
            return $this->send_response_unauthorize('Token Already Exist!');
        }
        $token = WhatsappToken::create([
            'user_id'   => $user_id,
            'value'     => $request->value,
            'from'      => $request->from,
            'desc'      => $request->desc,
        ]);
        return $this->send_response('Token Created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $token = WhatsappToken::with('user')->where('user_id', auth()->id())->find($id);
        if (!$token) {
            return $this->send_response_not_found();
        }
        $data = new WhatsappTokenResource($token);
        return  $data->additional(['data' => ['detail' => $token->detail()]]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user_id = auth()->id();
        $token = WhatsappToken::where('user_id', $user_id)->find($id);
        if (!$token) {
            return $this->send_response_not_found();
        }
        $this->validate($request, [
            'value' => 'required|max:100',
            'from'  => 'required|in:FONNTE',
            'desc'  => 'nullable|max:100',
        ]);
        $token_exist = WhatsappToken::query()->where('user_id', $user_id)
            ->where('value', $request->value)->whereKeyNot($id)->first();
        if ($token_exist) {
            return $this->send_response_unauthorize('Token Already Exist!');
        }
        $token->update([
            'user_id'   => $user_id,
            'value'     => $request->value,
            'from'      => $request->from,
            'desc'      => $request->desc,
        ]);
        return $this->send_response('Token Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $token = WhatsappToken::where('user_id', auth()->id())->find($id);
        if (!$token) {
            return $this->send_response_not_found();
        }
        $token->delete();
        return $this->send_response('Token Deleted!');
    }

    /**
     * Remove the selection ids resource from storage.
     */
    public function destroyBatch(Request $request)
    {
        $this->validate($request, [
            'id'        => 'required|array|min:1',
            'id.*'      => 'integer|exists:whatsapp_tokens,id',
        ]);
        $ids = $request->id;
        $deleted = WhatsappToken::whereIn('id', $ids)->where('user_id', auth()->id())->delete();
        $message = 'Success Delete : ' . $deleted . ' & Fail : ' . (count($request->id) - $deleted);
        return $this->send_response($message);
    }

    public function sync(Request $request)
    {
        $this->validate($request, [
            'from'  => 'required|in:FONNTE',
            'token' => 'required',
        ]);
        try {
            $data = FonnteServices::get_all_user_devices($request->token);
            return $this->send_response('', $data);
        } catch (\Throwable $th) {
            return $this->send_error($th->getMessage());
        }
    }
}
