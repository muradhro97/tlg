<?php

namespace App\Http\Controllers\Admin;

use App\ExpenseItem;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;




class ExpenseItemController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('permission:allExpenseItem', ['only' => ['index']]);
        $this->middleware('permission:addExpenseItem', ['only' => ['create', 'store']]);
        $this->middleware('permission:editExpenseItem', ['only' => ['edit', 'update']]);
        $this->middleware('permission:deleteExpenseItem', ['only' => ['destroy']]);


    }
    public function index(Request $request)
    {
        //
        $rows = ExpenseItem::latest();
        if ($request->filled('name')) {
            $rows->where('name', 'like', "%$request->name%");


        }

        $rows = $rows->paginate(20);

        return view('admin.expense_item.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ExpenseItem $model)
    {
//        return "asa";
        return view('admin.expense_item.create', compact('model'));
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
            'name' => 'required|unique:expense_items,name',



        ]);

//return  $images = $request->file('images');

        $row = ExpenseItem::create($request->all());
//        $client->roles()->sync($request->input('role'));
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The Expense Item  :subject.name created');
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/expense-item');
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
        $model = ExpenseItem::findOrFail($id);
        return view('admin.expense_item.edit', compact('model'));
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
            'name' => 'required|unique:expense_items,name,' . $id,




        ]);

        $row = ExpenseItem::findOrFail($id);
        $row->update($request->all());

        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The Expense Item :subject.name updated');
//        $client->roles()->sync($request->role);
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/expense-item/' );

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $row = ExpenseItem::findOrFail($id);



        $row->delete();
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The Expense Item  :subject.name deleted');
        toastr()->success(trans('main.delete_done_successfully'));
        return back();

    }


}
