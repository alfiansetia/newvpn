<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FileResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class DatabaseBackupController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index(Request $request)
    {
        $path = storage_path('app/backup');
        if (!file_exists($path)) {
            File::makeDirectory($path);
        }
        $file = File::files($path);
        return DataTables::collection($file)->setTransformer(function ($item) {
            return FileResource::make($item)->resolve();
        })->toJson();
    }

    public function store()
    {
        try {
            Artisan::call('database:backup');
            return response()->json([
                'data'      => [],
                'message'   => 'Success creating backup!',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data'      => [],
                'message'   => 'Error creating backup : ' . $th->getMessage(),
            ], 500);
        }
    }

    public function show(string $file)
    {
        $path = storage_path('app/backup/' . $file);
        if (empty($file) || !file_exists($path)) {
            return $this->send_response_not_found();
        }
        return response()->download($path);
    }

    public function destroy(string $file)
    {
        $path = storage_path('app/backup/' . $file);
        if (empty($file) || !file_exists($path)) {
            return $this->send_response_not_found();
        }
        File::delete($path);
        return $this->send_response('Backup File Deleted!');
    }

    public function destroyBatch()
    {
        try {
            File::cleanDirectory(storage_path('app/backup/'));
            return $this->send_response('All Backup File Deleted!');
        } catch (\Throwable $th) {
            return $this->send_error('Delete All Backup File Failed! : ' . $th->getMessage());
        }
    }
}
