<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait CrudTrait
{
    protected $model;

    public $with = [];
    public $filters = [];

    public function paginate()
    {
        $data = $this->model->query()->filter($this->filters)->with($this->with)->paginate(10);
        return response()->json($data);
    }

    public function destroyBatch(Request $request)
    {
        $this->validate($request, [
            'id'        => 'required|array|min:1',
            'id.*'      => 'required|integer|exists:' . $this->model . ',id',
        ]);
        $ids = $request->id;
        $deleted = $this->model::whereIn('id', $ids)->delete();
        $total = (count($request->id) - $deleted);
        $message = 'Success Delete : ' . $deleted . ' & Fail : ' . $total;
        return $this->response($message, $deleted);
    }

    public function destroy(Request $request, string $id)
    {
        $data = $this->model::find($id);
        if (!$data) {
            return response()->json(['message' => 'Data Not Found!'], 404);
        }
        $data->delete();
        return response()->json(['message' => 'Success Delete Data']);
    }

    public function show(Request $request, string $id,)
    {
        $data = $this->model::with($this->with)->find($id);
        if (!$data) {
            return response()->json(['message' => 'Data Not Found!'], 404);
        }
        return response()->json(['message' => '', 'data' => $data]);
    }
}
