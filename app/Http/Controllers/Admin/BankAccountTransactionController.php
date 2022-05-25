<?php

namespace App\Http\Controllers\Admin;

use App\BankAccount;


use App\SafeTransaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;




class BankAccountTransactionController extends Controller
{
    //

    public function __construct()
    {
//        $this->middleware('permission:allBankAccount', ['only' => ['index']]);
//        $this->middleware('permission:addBankAccount', ['only' => ['create', 'store']]);
//        $this->middleware('permission:editBankAccount', ['only' => ['edit', 'update']]);
//        $this->middleware('permission:deleteBankAccount', ['only' => ['destroy']]);


    }
    public function accountingSafeTransaction(Request $request)
    {
        $rows = SafeTransaction::latest()
            ->where('safe_id', 0)
//            ->where('module', 'accounting')
        ;
        if ($request->filled('type')) {
//            dd($request->type);
//            $rows->where('type', $request->type);
// $query->whereHas('payment', function ($q2) use ($request) {
//            $rows->whereHas('payment', function ($q2) use ($request) {
//                $q2->where('type', 'cashin');
//
//            });



            $rows->where(function($query)use($request){
                $query->whereHas('accounting', function ($q) use ($request) {
                    $q->where('type', $request->type);

                });
                $query->orWhereHas('payment', function ($q2) use ($request) {
                    $q2->where('type', $request->type);

                });
            });

        }
        if ($request->filled('module')) {
            $rows->where('module', $request->module);
        }
//        if ($request->filled('safe')) {
//            $rows->where('safe', $request->safe);
//        }
        if ($request->filled('from')) {
            $rows->whereHas('parent',function ($query)use ($request){
                return $query->where('date','>=',$request->from);
            });
        }
        if ($request->filled('to')) {
            $rows->whereHas('parent',function ($query)use ($request){
                return $query->where('date','<=',$request->to);
            });
        }
        $rows = $rows->paginate(100);

        return view('admin.bank_account_transaction.accounting_safe_transaction', compact('rows'));
    }
    public function accountingBankAccountTransaction(Request $request)
    {
        //
        $rows = SafeTransaction::latest()
            ->where('safe_id','!=', 0)
//            ->where('module', 'accounting')
        ;
        if ($request->filled('type')) {
//            dd($request->type);
//            $rows->where('type', $request->type);
// $query->whereHas('payment', function ($q2) use ($request) {
//            $rows->whereHas('payment', function ($q2) use ($request) {
//                $q2->where('type', 'cashin');
//
//            });



            $rows->where(function($query)use($request){
                $query->whereHas('accounting', function ($q) use ($request) {
                    $q->where('type', $request->type);

                });
                $query->orWhereHas('payment', function ($q2) use ($request) {
                    $q2->where('type', $request->type);

                });
            });

        }
        if ($request->filled('module')) {
            $rows->where('module', $request->module);
        }
//        if ($request->filled('safe')) {
//            $rows->where('safe', $request->safe);
//        }


        if ($request->filled('from')) {
            $rows->where('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $rows->where('created_at', '<=', $request->to);
        }
        $rows = $rows->paginate(100);

        return view('admin.bank_account_transaction.accounting_bank_account_transaction', compact('rows'));
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
