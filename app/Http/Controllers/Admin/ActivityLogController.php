<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    //
    public function __construct()
    {

        $this->middleware('permission:activityLog', ['only' => ['index']]);
//        $this->middleware(['permission:addUser|editUser|deleteUser']);
    }
    public function index(Request $request)
    {
        //
        $rows = Activity::latest();

        if ($request->filled('description')) {
            $rows->where('description', 'like', "%$request->description%");

        }
        if ($request->filled('user_id')) {
            $rows->where('causer_id', $request->user_id);


        }
        $rows = $rows->paginate(20);


        return view('admin.activity_log.index', compact('rows'));
    }
}
