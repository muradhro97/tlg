<?php

namespace App\Http\Controllers\Admin;

use App\Unit;



use Illuminate\Http\Request;
use App\Http\Controllers\Controller;




class UnitController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('permission:allUnit', ['only' => ['index']]);
        $this->middleware('permission:addUnit', ['only' => ['create', 'store']]);
        $this->middleware('permission:editUnit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:deleteUnit', ['only' => ['destroy']]);


    }

    public function index(Request $request)
    {
        //
        $rows = Unit::latest();
        if ($request->filled('name')) {
            $rows->where('name', 'like', "%$request->name%");


        }

        $rows = $rows->paginate(20);

        return view('admin.unit.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Unit $model)
    {
//        return "asa";
        return view('admin.unit.create', compact('model'));
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
            'name' => 'required|unique:units,name',


        ]);

//return  $images = $request->file('images');

        $row = Unit::create($request->all());
//        $client->roles()->sync($request->input('role'));
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The unit :subject.name created');
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/unit');
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
        $model = Unit::findOrFail($id);
        return view('admin.unit.edit', compact('model'));
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
            'name' => 'required|unique:units,name,' . $id,



        ]);

        $row = Unit::findOrFail($id);
        $row->update($request->all());

        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The unit :subject.name updated');
//        $client->roles()->sync($request->role);
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/unit/');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $row = Unit::findOrFail($id);



        $row->delete();
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The unit :subject.name deleted');
        toastr()->success(trans('main.delete_done_successfully'));
        return back();

    }


}
