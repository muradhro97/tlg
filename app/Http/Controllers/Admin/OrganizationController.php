<?php

namespace App\Http\Controllers\Admin;

use App\Library\Field;
use App\Organization;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;




class OrganizationController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('permission:allOrganization', ['only' => ['index']]);
        $this->middleware('permission:addOrganization', ['only' => ['create', 'store']]);
        $this->middleware('permission:editOrganization', ['only' => ['edit', 'update']]);
        $this->middleware('permission:deleteOrganization', ['only' => ['destroy']]);


    }
    public function index(Request $request)
    {
        //
        $rows = Organization::latest();
        if ($request->filled('name')) {
            $rows->where('name', 'like', "%$request->name%");


        }
        if ($request->filled('type')) {
            $rows->where('type',  $request->type);


        }

        if ($request->filled('phone')) {
            $rows->where('phone',  $request->phone);


        }
        $rows = $rows->paginate(20);

        return view('admin.organization.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Organization $model)
    {
//        return "asa";
        return view('admin.organization.create', compact('model'));
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
            'phone' => 'required',
            'tax_no' => 'required',
            'commercial_no' => 'required',
            'address' => 'required',
            'type' => 'required|in:owner,mainContractor,subContractor,supplier',
            'name' => 'required',


        ]);

//return  $images = $request->file('images');

        $row = Organization::create($request->all());
//        $client->roles()->sync($request->input('role'));
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The organization :subject.name created');
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/organization');
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
        $model = Organization::findOrFail($id);
        return view('admin.organization.edit', compact('model'));
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


            'phone' => 'required',
            'tax_no' => 'required',
            'commercial_no' => 'required',
            'address' => 'required',
            'type' => 'required|in:owner,mainContractor,subContractor,supplier',
            'name' => 'required',



        ]);

        $row = Organization::findOrFail($id);
        $row->update($request->all());

        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The organization :subject.name updated');
//        $client->roles()->sync($request->role);
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/organization/' );

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $row = Organization::findOrFail($id);



        $row->delete();
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The organization :subject.name deleted');
        toastr()->success(trans('main.delete_done_successfully'));
        return back();

    }

    public function projects(Organization $organization){
        $subcontracts = $organization->subcontracts()->pluck('no', 'id')->toArray();
        return Field::select('sub_contract_id' , trans('main.sub_contract'),$subcontracts,trans('main.select_sub_contract'));
    }

    public function contracts(Organization $organization){
        $contracts = $organization->contracts()->pluck('no', 'id')->toArray();
        return Field::select('contract_id' , trans('main.contract'),$contracts,trans('main.select_contract'));
    }


}
