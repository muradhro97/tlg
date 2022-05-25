<?php

namespace App\Http\Controllers\Admin;

use App\LaborsGroup;



use Illuminate\Http\Request;
use App\Http\Controllers\Controller;




class LaborsGroupController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('permission:allLaborGroup', ['only' => ['index']]);
        $this->middleware('permission:addLaborGroup', ['only' => ['create', 'store']]);
        $this->middleware('permission:editLaborGroup', ['only' => ['edit', 'update']]);
        $this->middleware('permission:deleteLaborGroup', ['only' => ['destroy']]);


    }
    public function index(Request $request)
    {
        //
        $rows = LaborsGroup::latest();
        if ($request->filled('name')) {
            $rows->where('name', 'like', "%$request->name%");


        }

        $rows = $rows->paginate(20);

        return view('admin.labors_group.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(LaborsGroup $model)
    {
//        return "asa";
        return view('admin.labors_group.create', compact('model'));
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
            'name' => 'required|unique:labors_groups,name',


        ]);

//return  $images = $request->file('images');

        $row = LaborsGroup::create($request->all());
//        $client->roles()->sync($request->input('role'));
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The labors group :subject.name created');
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/labors-group');
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
        $model = LaborsGroup::findOrFail($id);
        return view('admin.labors_group.edit', compact('model'));
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
            'name' => 'required|unique:labors_groups,name,' . $id,



        ]);

        $row = LaborsGroup::findOrFail($id);
        $row->update($request->all());

        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The labors group :subject.name updated');
//        $client->roles()->sync($request->role);
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/labors-group/' );

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $row = LaborsGroup::findOrFail($id);



        $row->delete();
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The labors group :subject.name deleted');
        toastr()->success(trans('main.delete_done_successfully'));
        return back();

    }


}
