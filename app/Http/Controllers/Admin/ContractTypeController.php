<?php

namespace App\Http\Controllers\Admin;

use App\ContractType;



use Illuminate\Http\Request;
use App\Http\Controllers\Controller;




class ContractTypeController extends Controller
{
    //


    public function index(Request $request)
    {
        //
        $rows = ContractType::latest();
        if ($request->filled('name')) {
            $rows->where('name', 'like', "%$request->name%");


        }

        $rows = $rows->paginate(20);

        return view('admin.contract_type.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ContractType $model)
    {
//        return "asa";
        return view('admin.contract_type.create', compact('model'));
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
            'name' => 'required|unique:contract_types,name',


        ]);

//return  $images = $request->file('images');

        $row = ContractType::create($request->all());
//        $client->roles()->sync($request->input('role'));
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The contract type :subject.name created');
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/contract-type');
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
        $model = ContractType::findOrFail($id);
        return view('admin.contract_type.edit', compact('model'));
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
            'name' => 'required|unique:contract_types,name,' . $id,



        ]);

        $row = ContractType::findOrFail($id);
        $row->update($request->all());

        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The contract type :subject.name updated');
//        $client->roles()->sync($request->role);
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/contract-type/');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $row = ContractType::findOrFail($id);



        $row->delete();
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The contract type :subject.name deleted');
        toastr()->success(trans('main.delete_done_successfully'));
        return back();

    }


}
