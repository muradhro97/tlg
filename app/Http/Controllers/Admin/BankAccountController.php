<?php

namespace App\Http\Controllers\Admin;

use App\BankAccount;



use Illuminate\Http\Request;
use App\Http\Controllers\Controller;




class BankAccountController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('permission:allBankAccount', ['only' => ['index']]);
        $this->middleware('permission:addBankAccount', ['only' => ['create', 'store']]);
        $this->middleware('permission:editBankAccount', ['only' => ['edit', 'update']]);
        $this->middleware('permission:deleteBankAccount', ['only' => ['destroy']]);


    }
    public function index(Request $request)
    {
        //
        $rows = BankAccount::latest();
        if ($request->filled('name')) {
            $rows->where('name', 'like', "%$request->name%");


        }

        $rows = $rows->paginate(20);

        return view('admin.bank_account.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(BankAccount $model)
    {
//        return "asa";
        return view('admin.bank_account.create', compact('model'));
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
            'name' => 'required|unique:safes,name',
            'initial_balance' => 'required|numeric|min:0',


        ]);

//return  $images = $request->file('images');
        $request->merge(['balance' =>$request->initial_balance]);
        $row = BankAccount::create($request->all());
//        $client->roles()->sync($request->input('role'));
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The bank account :subject.name created');
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/bank-account');
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
        $model = BankAccount::findOrFail($id);
        return view('admin.bank_account.edit', compact('model'));
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
            'name' => 'required|unique:safes,name,' . $id,



        ]);

        $row = BankAccount::findOrFail($id);
        $row->update([
            'name'=>$request->name
        ]);

        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The bank account :subject.name updated');
//        $client->roles()->sync($request->role);
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/bank-account');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
return "";
        $row = BankAccount::findOrFail($id);



        $row->delete();
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The bank account :subject.name deleted');
        toastr()->success(trans('main.delete_done_successfully'));
        return back();

    }


}
