<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NewsResource;
use App\Models\News;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function paginate(Request $request)
    {
        $limit = $this->get_limit($request);
        $filters = $request->only(['name', 'email']);
        $data = News::query()->filter($filters)->paginate($limit)->withQueryString();
        return NewsResource::collection($data);
    }

    public function index(Request $request)
    {
        $filters = $request->only(['name', 'email']);
        $query = News::query()->filter($filters);
        return DataTables::eloquent($query)->setTransformer(function ($item) {
            return NewsResource::make($item)->resolve();
        })->toJson();
    }

    public function show(News $news)
    {
        return new NewsResource($news);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title'     => 'required|string|max:150|min:3',
            'content'   => 'required|string|max:5000|min:3',
            'status'    => 'nullable|in:draft,published,archived',
        ]);
        $status = ($request->status == 'published') ? now() : null;
        $rand = Str::random(4);
        $slug = Str::slug($request->title . '-' . $rand);
        $news = News::create([
            'title'         => $request->title,
            'slug'          => $slug,
            'content'       => $request->content,
            'status'        => $request->status,
            'published_at'  => $status,
        ]);
        return $this->send_response('Success Insert Data');
    }

    public function update(Request $request, News $news)
    {
        $this->validate($request, [
            'title'     => 'required|string|max:150|min:3',
            'content'   => 'required|string|max:5000|min:3',
            'status'    => 'nullable|in:draft,published,archived',
        ]);
        if ($request->status == 'published' && is_null($news->published_at)) {
            $publishedAt = now();
        } else {
            $publishedAt = $news->published_at;
        }
        $news->update([
            'title'         => $request->title,
            'content'       => $request->content,
            'status'        => $request->status,
            'published_at'  => $publishedAt,
        ]);
        return $this->send_response('Success Update Data');
    }

    public function destroy(News $news)
    {
        $news->delete();
        return $this->send_response('Success Delete Data');
    }

    public function destroyBatch(Request $request)
    {
        $this->validate($request, [
            'id'        => 'required|array|min:1',
            'id.*'      => 'integer|exists:news,id',
        ]);
        $ids = $request->id;
        $deleted = News::whereIn('id', $ids)->delete();
        $message = 'Success Delete : ' . $deleted . ' & Fail : ' . (count($request->id) - $deleted);
        return $this->send_response($message);
    }
}
