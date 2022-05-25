<?php

namespace App\Http\Controllers\Admin;

use App\Project;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ProjectController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('permission:allProject', ['only' => ['index']]);
        $this->middleware('permission:addProject', ['only' => ['create', 'store']]);
        $this->middleware('permission:editProject', ['only' => ['edit', 'update']]);
        $this->middleware('permission:deleteProject', ['only' => ['destroy']]);


    }

    public function index(Request $request)
    {
        //
        $rows = Project::latest();
        if ($request->filled('name')) {
            $rows->where('name', 'like', "%$request->name%");


        }

        $rows = $rows->paginate(20);

        return view('admin.project.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Project $model)
    {
//        return "asa";
        return view('admin.project.create', compact('model'));
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

            'name' => 'required',
            'abbreviation' => 'required|max:255',

        ]);

//return  $images = $request->file('images');

        $row = Project::create($request->all());
//        $client->roles()->sync($request->input('role'));
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The project :subject.name created');
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/project');
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
        $model = Project::findOrFail($id);
        return view('admin.project.edit', compact('model'));
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

            'name' => 'required',
            'abbreviation' => 'required|max:255',

        ]);

        $row = Project::findOrFail($id);
        $row->update($request->all());

        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The project :subject.name updated');
//        $client->roles()->sync($request->role);
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/project');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $row = Project::findOrFail($id);


        $row->delete();
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The project :subject.name deleted');
        toastr()->success(trans('main.delete_done_successfully'));
        return back();

    }


}
