<?php

namespace App\Http\Controllers\Admin;

use App\Bank;



use Illuminate\Http\Request;
use App\Http\Controllers\Controller;




class BankController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('permission:allBank', ['only' => ['index']]);
        $this->middleware('permission:addBank', ['only' => ['create', 'store']]);
        $this->middleware('permission:editBank', ['only' => ['edit', 'update']]);
        $this->middleware('permission:deleteBank', ['only' => ['destroy']]);


    }

    public function index(Request $request)
    {
        //
        $rows = Bank::latest();
        if ($request->filled('name')) {
            $rows->where('name', 'like', "%$request->name%");


        }

        $rows = $rows->paginate(20);

        return view('admin.bank.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Bank $model)
    {
//        return "asa";
        return view('admin.bank.create', compact('model'));
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
            'name' => 'required|unique:banks,name',


        ]);

//return  $images = $request->file('images');

        $row = Bank::create($request->all());
//        $client->roles()->sync($request->input('role'));
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The bank  :subject.name created');
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/bank');
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
        $model = Bank::findOrFail($id);
        return view('admin.bank.edit', compact('model'));
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
            'name' => 'required|unique:banks,name,' . $id,



        ]);

        $row = Bank::findOrFail($id);
        $row->update($request->all());

        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The bank  :subject.name updated');
//        $client->roles()->sync($request->role);
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/bank/');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $row = Bank::findOrFail($id);



        $row->delete();
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The bank  :subject.name deleted');
        toastr()->success(trans('main.delete_done_successfully'));
        return back();

    }


}
