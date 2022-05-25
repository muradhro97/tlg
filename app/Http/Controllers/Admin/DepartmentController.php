<?php

namespace App\Http\Controllers\Admin;

use App\Department;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;




class DepartmentController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('permission:allDepartment', ['only' => ['index']]);
        $this->middleware('permission:addDepartment', ['only' => ['create', 'store']]);
        $this->middleware('permission:editDepartment', ['only' => ['edit', 'update']]);
        $this->middleware('permission:deleteDepartment', ['only' => ['destroy']]);


    }
    public function index(Request $request)
    {
        //
        $rows = Department::latest();
        if ($request->filled('name')) {
            $rows->where('name', 'like', "%$request->name%");


        }

        $rows = $rows->paginate(20);

        return view('admin.department.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Department $model)
    {
//        return "asa";
        return view('admin.department.create', compact('model'));
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
//            'user_name' => 'required|unique:users,user_name',
            'name' => 'required|unique:departments,name',


        ]);

//return  $images = $request->file('images');

        $row = Department::create($request->all());
//        $client->roles()->sync($request->input('role'));
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The department  :subject.name created');
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/department');
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
//        $row = Department::find($id);
//        $orderCount = $row->orders()->count();
//        $orders = $row->orders()->paginate(10);
//        $transactions = $row->transactions()->take(10)->get();
//        return view('admin.department.show', compact('row', 'orderCount', 'orders', 'transactions'));
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
        $model = Department::findOrFail($id);
        return view('admin.department.edit', compact('model'));
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
//            'user_name' => 'required|unique:users,user_name,' . $id,
//            'phone' => 'required|unique:clients,phone',
            'name' => 'required|unique:departments,name,' . $id,



        ]);

        $row = Department::findOrFail($id);
        $row->update($request->all());
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The department  :subject.name updated');

//        $client->roles()->sync($request->role);
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/department/' );

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $row = Department::findOrFail($id);



        $row->delete();
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The department  :subject.name deleted');
        toastr()->success(trans('main.delete_done_successfully'));
        return back();

    }


}
