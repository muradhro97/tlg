<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    //

    public function index()
    {
        //
//        $role = Role::create(['name' => 'admin']);
//        return $role;
        $rows = User::latest()->paginate(20);

        return view('admin.user.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(User $model)
    {
//        return "asa";
        return view('admin.user.create', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
//        return $request->all();

        $this->validate($request, [
            'user_name' => 'required|unique:users,user_name',
            'email' => 'required|email|unique:users,email',
            'name' => 'required',
            'password' => 'required|confirmed',

        ]);
        $request->merge(['password' => Hash::make($request->password)]);
        $row = User::create($request->except('password_confirmation'));
        $row->projects()->sync($request->projects_list);

//        $user->roles()->sync($request->input('role'));

        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The user :subject.name created');
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/user');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $model = User::findOrFail($id);
        return view('admin.user.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        $this->validate($request, [
            'user_name' => 'required|unique:users,user_name,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'name' => 'required',
            'password' => 'confirmed',


        ]);
//        $request->merge(['password' => Hash::make($request->password)]);
        $row = User::findOrFail($id);
        if ($request->filled('password')) {
            $request->merge(['password' => Hash::make($request->password)]);

            $row->update($request->except('password_confirmation'));
        } else {

            $row->update($request->except('password', 'password_confirmation'));
        }
        $row->projects()->sync($request->projects_list);
//        $row->assignRole('admin');
//        $row->update($request->all());
//        $user->roles()->sync($request->role);
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The user :subject.name updated');
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/user/' );

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $row = User::findOrFail($id);
        $row->projects()->detach();
        $row->delete();
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The user :subject.name deleted');
        toastr()->success(trans('main.delete_done_successfully'));
        return back();

    }
}
