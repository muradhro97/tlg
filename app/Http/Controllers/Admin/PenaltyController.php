<?php

namespace App\Http\Controllers\Admin;

use App\Penalty;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;




class PenaltyController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('permission:allPenalty', ['only' => ['index']]);
        $this->middleware('permission:addPenalty', ['only' => ['create', 'store']]);
        $this->middleware('permission:editPenalty', ['only' => ['edit', 'update']]);
        $this->middleware('permission:deletePenalty', ['only' => ['destroy']]);


    }
    public function index(Request $request)
    {
        //
        $rows = Penalty::latest();
        if ($request->filled('name')) {
            $rows->where('name', 'like', "%$request->name%");
        }

        if ($request->filled('date')) {
            $rows->where('date', $request->date);
        }

        $rows = $rows->paginate(20);

        return view('admin.penalty.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Penalty $model)
    {
//        return "asa";
        return view('admin.penalty.create', compact('model'));
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
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date|date_format:Y-m-d',
            'amount' => 'required|numeric|min:1',


        ]);

//return  $images = $request->file('images');

        $row = Penalty::create($request->all());
//        $client->roles()->sync($request->input('role'));
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The penalty  :subject.id created');
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/penalty');
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
//        $row = Penalty::find($id);
//        $orderCount = $row->orders()->count();
//        $orders = $row->orders()->paginate(10);
//        $transactions = $row->transactions()->take(10)->get();
//        return view('admin.penalty.show', compact('row', 'orderCount', 'orders', 'transactions'));
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
        $model = Penalty::findOrFail($id);
        if ($model->accounting_id) {
            return redirect('admin/penalty');
        }
        return view('admin.penalty.edit', compact('model'));
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
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date|date_format:Y-m-d',
            'amount' => 'required|numeric|min:1',



        ]);

        $row = Penalty::findOrFail($id);
        if ($row->accounting_id) {
            return redirect('admin/penalty');
        }
        $row->update($request->all());

        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The penalty :subject.id updated');
//        $client->roles()->sync($request->role);
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/penalty/');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $row = Penalty::findOrFail($id);


        if ($row->accounting_id) {
            return redirect('admin/penalty');
        }
        $row->delete();
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The penalty  :subject.name deleted');
        toastr()->success(trans('main.delete_done_successfully'));
        return back();

    }


}
