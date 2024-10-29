<?php

namespace App\Http\Controllers;

use App\Models\BalanceHistory;
use App\Models\Topup;
use App\Traits\CrudTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class TopupController extends Controller
{
    use CrudTrait;

    public function __construct()
    {
        $this->model = Topup::class;
        $this->with = ['user:id,name,email', 'bank:id,name,acc_name,acc_number'];
        $this->middleware(['role:admin'])->only(['update', 'destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        if ($user->is_admin()) {
            return view('topup.index');
        } else {
            return view('topup.index_user');
        }
    }
}
