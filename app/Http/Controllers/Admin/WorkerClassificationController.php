<?php

namespace App\Http\Controllers\Admin;

use App\WorkerClassification;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;




class WorkerClassificationController extends Controller
{
    //

    public function __construct()
    {
//        $this->middleware('permission:allCountry', ['only' => ['index']]);
//        $this->middleware('permission:addCountry', ['only' => ['create', 'store']]);
//        $this->middleware('permission:editCountry', ['only' => ['edit', 'update']]);
//        $this->middleware('permission:deleteCountry', ['only' => ['destroy']]);


    }
    public function index(Request $request)
    {
        //
        $rows = WorkerClassification::latest();
        if ($request->filled('name')) {
            $rows->where('name', 'like', "%$request->name%");


        }

        $rows = $rows->paginate(20);

        return view('admin.worker_classification.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(WorkerClassification $model)
    {
//        return "asa";
        return view('admin.worker_classification.create', compact('model'));
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
            'name' => 'required|unique:countries,name',
            'unit_price' => 'required',


        ]);

//return  $images = $request->file('images');

        $row = WorkerClassification::create($request->all());
//        $client->roles()->sync($request->input('role'));
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The Worker Classification  :subject.name created');
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/worker-classification');
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
//        $row = WorkerClassification::find($id);
//        $orderCount = $row->orders()->count();
//        $orders = $row->orders()->paginate(10);
//        $transactions = $row->transactions()->take(10)->get();
//        return view('admin.country.show', compact('row', 'orderCount', 'orders', 'transactions'));
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
        $model = WorkerClassification::findOrFail($id);
        return view('admin.worker_classification.edit', compact('model'));
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
            'name' => 'required|unique:countries,name,' . $id,
            'unit_price' => 'required',



        ]);

        $row = WorkerClassification::findOrFail($id);
        $row->update($request->all());

        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The Worker Classification :subject.name updated');
//        $client->roles()->sync($request->role);
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/worker-classification/');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $row = WorkerClassification::findOrFail($id);



        $row->delete();
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The Worker Classification  :subject.name deleted');
        toastr()->success(trans('main.delete_done_successfully'));
        return back();

    }


}
