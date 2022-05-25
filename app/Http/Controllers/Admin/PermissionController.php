<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    //
    public function __construct()
    {

        $this->middleware('permission:perUser', ['only' => ['index','savePermissions']]);
//        $this->middleware(['permission:addUser|editUser|deleteUser']);
    }
    public function index($id)
    {
        $user= User::find($id);
            $permissions = $user->getPermissionNames()->toarray();
//        $permission = Permission::create(['name' => 'edit articles']);
        return view('admin.permissions.index', compact('id','permissions'));
    }

    public function savePermissions(Request $request)
    {
//        return  $request->all();
        $user= User::find($request->user_id);
//        return $request->per;
        $user->syncPermissions($request->per);
        activity()
            ->performedOn($user)
            ->causedBy(auth()->user())
            ->log('The permissions :subject.name updated');
        toastr()->success(trans('main.save_done_successfully'));
        return back();
    }


}
