<?php

namespace App\Http\Controllers\Admin;

use App\LaborsDepartment;



use Illuminate\Http\Request;
use App\Http\Controllers\Controller;




class LaborsDepartmentController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('permission:allLaborDepartment', ['only' => ['index']]);
        $this->middleware('permission:addLaborDepartment', ['only' => ['create', 'store']]);
        $this->middleware('permission:editLaborDepartment', ['only' => ['edit', 'update']]);
        $this->middleware('permission:deleteLaborDepartment', ['only' => ['destroy']]);


    }

    public function index(Request $request)
    {
        //
        $rows = LaborsDepartment::latest();
        if ($request->filled('name')) {
            $rows->where('name', 'like', "%$request->name%");


        }

        $rows = $rows->paginate(20);

        return view('admin.labors_department.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(LaborsDepartment $model)
    {
//        return "asa";
        return view('admin.labors_department.create', compact('model'));
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
            'name' => 'required|unique:labors_departments,name',


        ]);

//return  $images = $request->file('images');

        $row = LaborsDepartment::create($request->all());
//        $client->roles()->sync($request->input('role'));
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The labors department :subject.name created');
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/labors-department');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
        $model = LaborsDepartment::findOrFail($id);
        return view('admin.labors_department.edit', compact('model'));
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
            'name' => 'required|unique:labors_departments,name,' . $id,



        ]);

        $row = LaborsDepartment::findOrFail($id);
        $row->update($request->all());

        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The labors department :subject.name updated');
//        $client->roles()->sync($request->role);
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/labors-department/' );

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $row = LaborsDepartment::findOrFail($id);



        $row->delete();
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The labors department :subject.name deleted');
        toastr()->success(trans('main.delete_done_successfully'));
        return back();

    }


}
