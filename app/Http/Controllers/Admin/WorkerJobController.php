<?php

namespace App\Http\Controllers\Admin;

use App\WorkerJob;



use Illuminate\Http\Request;
use App\Http\Controllers\Controller;




class WorkerJobController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('permission:allWorkerJob', ['only' => ['index']]);
        $this->middleware('permission:addWorkerJob', ['only' => ['create', 'store']]);
        $this->middleware('permission:editWorkerJob', ['only' => ['edit', 'update']]);
        $this->middleware('permission:deleteWorkerJob', ['only' => ['destroy']]);


    }
    public function index(Request $request)
    {
        //
        $rows = WorkerJob::latest();
        if ($request->filled('name')) {
            $rows->where('name', 'like', "%$request->name%");


        }

        $rows = $rows->paginate(20);

        return view('admin.worker_job.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(WorkerJob $model)
    {
//        return "asa";
        return view('admin.worker_job.create', compact('model'));
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
            'name' => 'required|unique:jobs,name',
//            'type' => 'required',
            'daily_salary' => 'required|numeric|min:0',
            'hourly_salary' => 'required|numeric|min:0',
            'insurance' => 'required|numeric|min:0',
            'taxes' => 'required|numeric|min:0',
            'abbreviation' => 'required|max:255',


        ]);

//return  $images = $request->file('images');
        $request->merge(['type' =>'worker']);
        $row = WorkerJob::create($request->all());
//        $client->roles()->sync($request->input('role'));
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The worker job :subject.name created');
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/worker-job');
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
        $model = WorkerJob::findOrFail($id);
        return view('admin.worker_job.edit', compact('model'));
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
            'name' => 'required|unique:jobs,name,' . $id,
//            'type' => 'required',
            'abbreviation' => 'required|max:255',
            'daily_salary' => 'required|numeric|min:0',
            'hourly_salary' => 'required|numeric|min:0',
            'insurance' => 'required|numeric|min:0',
            'taxes' => 'required|numeric|min:0',



        ]);

        $row = WorkerJob::findOrFail($id);
        $row->update($request->all());

        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The worker job :subject.name updated');
//        $client->roles()->sync($request->role);
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/worker-job');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $row = WorkerJob::findOrFail($id);



        $row->delete();
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The worker job :subject.name deleted');
        toastr()->success(trans('main.delete_done_successfully'));
        return back();

    }


}
