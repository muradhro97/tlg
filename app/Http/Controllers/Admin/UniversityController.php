<?php

namespace App\Http\Controllers\Admin;

use App\University;



use Illuminate\Http\Request;
use App\Http\Controllers\Controller;




class UniversityController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('permission:allUniversity', ['only' => ['index']]);
        $this->middleware('permission:addUniversity', ['only' => ['create', 'store']]);
        $this->middleware('permission:editUniversity', ['only' => ['edit', 'update']]);
        $this->middleware('permission:deleteUniversity', ['only' => ['destroy']]);


    }
    public function index(Request $request)
    {
        //
        $rows = University::latest();
        if ($request->filled('name')) {
            $rows->where('name', 'like', "%$request->name%");


        }

        $rows = $rows->paginate(20);

        return view('admin.university.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(University $model)
    {
//        return "asa";
        return view('admin.university.create', compact('model'));
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
            'name' => 'required|unique:universities,name',


        ]);

//return  $images = $request->file('images');

        $row = University::create($request->all());
//        $client->roles()->sync($request->input('role'));
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The university :subject.name created');
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/university');
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
        $model = University::findOrFail($id);
        return view('admin.university.edit', compact('model'));
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
            'name' => 'required|unique:universities,name,' . $id,



        ]);

        $row = University::findOrFail($id);
        $row->update($request->all());
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The university :subject.name updated');

//        $client->roles()->sync($request->role);
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/university/' );

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $row = University::findOrFail($id);



        $row->delete();
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The university :subject.name deleted');
        toastr()->success(trans('main.delete_done_successfully'));
        return back();

    }


}
