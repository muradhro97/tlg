<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Item;
use App\StockItem;
use App\StockTransaction;
use App\StockTransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockTransactionController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('permission:stockTransaction', ['only' => ['index']]);

    }
    public function index(Request $request)
    {
        //

        $rows = StockTransaction::latest();
        if ($request->filled('module')) {
            $rows->where('module', $request->module);

        }

        if ($request->filled('type')) {
            $rows->where('type', $request->type);


        }

        if ($request->filled('item_id')) {
            $rows->where('item_id', $request->item_id);


        }

        if ($request->filled('date')) {
            $rows->where('date', $request->date);


        }
        $rows = $rows->paginate(20);

        return view('admin.stock_transaction.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function stockIn(StockTransaction $model)
    {
//        return "asa";
        return view('admin.stock_transaction.stock_in', compact('model'));
    }

    public function stockOut(StockTransaction $model)
    {
//        return "asa";
        return view('admin.stock_transaction.stock_out', compact('model'));
    }

    public function create(StockTransaction $model)
    {
//        return "asa";
        return view('admin.stock_transaction.create', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeStockIn(Request $request)
    {
        //
//        return $items = json_decode($request->items);
//        return $request->all();
        $rules = [

            'employee_id' => 'required|exists:employees,id',
            'approved_by' => 'required|exists:employees,id',
            'stock_type' => 'required|exists:stock_types,id',


            'details' => 'required',
            'total' =>'numeric|min:0',

            'type' => 'required|in:in,out',
            'date' => 'required|date|date_format:Y-m-d',
//            'custody_type' => 'required|in:consumed,permanent,refundable',


        ];
        $validator = validator()->make($request->all(), $rules);
        $validator->after(function ($validator) use ($request) {
//          return  $request->items;
            if (count(json_decode($request->items)) < 1) {
//            if (count(array_filter($request->items)) < 1) {

                $validator->errors()->add('items', trans('main.please_add_item'));
            }
        });

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();


        }

//return 123;
//return  $images = $request->file('images');
        DB::beginTransaction();
        try {
            $row = StockTransaction::create([
//            DB::table('client_transactions')->insert([

                'employee_id' => $request->employee_id,
                'approved_by' => $request->approved_by,
                'stock_type' => $request->stock_type,
                'details' => $request->details,
                'type' => $request->type,
                'date' => $request->date,
                'total' => $request->total,
                'custody_type' => $request->custody_type,


            ]);
            $items = json_decode($request->items);
            foreach ($items as $item) {
                $a= Item::find($item->item_id);
                $a->quantity= $a->quantity+ $item->quantity;
                $a->save();
                $d = new StockTransactionDetail();
                $d->stock_transaction_id = $row->id;
                $d->item_id = $item->item_id;
                $d->price = $item->price;
                $d->quantity = $item->quantity;
                $d->new_quantity = $a->quantity;
//                $d->total = $item->quantity * $item->price;
                $d->save();
            }

//        $client->roles()->sync($request->input('role'));
            DB::commit();
            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/stock-transaction');


        } catch (\Exception $e) {
            DB::rollBack();
//            dd($e->getMessage());
//            return $e->getMessage();
//            $error = $e->getMessage();
//            $html = view('partials.errors', compact('error'))->render();
//            $data = [
//                'status' => false,
//                'errors' => $html,
//            ];

//            return response()->json($data, 422);
//            flash()->error($e->getMessage());
            return back()->withErrors($e->getMessage())->withInput();
//            return back();


        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();
//            dd(456);
//            $error = $ex->errorInfo[2];
//            $html = view('partials.errors', compact('error'))->render();
//            $data = [
//                'status' => false,
//                'errors' => $html,
//            ];

//            return response()->json($data, 422);
//            flash()->error($ex->errorInfo[2]);

            return back()->withErrors($ex->errorInfo[2])->withInput();

        }
    }
    public function storeStockOut(Request $request)
    {
        //
//        return $items = json_decode($request->items);
//        return $request->all();
        $rules = [

            'employee_id' => 'required|exists:employees,id',
            'approved_by' => 'required|exists:employees,id',
            'stock_type' => 'required|exists:stock_types,id',


            'details' => 'required',
            'total' =>'numeric|min:0',

            'type' => 'required|in:in,out',
            'date' => 'required|date|date_format:Y-m-d',
            'custody_type' => 'required|in:consumed,permanent,refundable',


        ];
        $validator = validator()->make($request->all(), $rules);
        $validator->after(function ($validator) use ($request) {
//          return  $request->items;
            if (count(json_decode($request->items)) < 1) {
//            if (count(array_filter($request->items)) < 1) {

                $validator->errors()->add('items', trans('main.please_add_item'));
            }
        });

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();


        }

//return 123;
//return  $images = $request->file('images');
        DB::beginTransaction();
        try {
            $row = StockTransaction::create([
//            DB::table('client_transactions')->insert([

                'employee_id' => $request->employee_id,
                'approved_by' => $request->approved_by,
                'stock_type' => $request->stock_type,
                'details' => $request->details,
                'type' => $request->type,
                'date' => $request->date,
                'total' => $request->total,
                'custody_type' => $request->custody_type,


            ]);
            $items = json_decode($request->items);
            foreach ($items as $item) {
                $a= Item::find($item->item_id);
                if($item->quantity> $a->quantity){
                    DB::rollBack();
                    return back()->withErrors($a->name .' item '.trans('main.quantity_bigger_than_stock_quantity'))->withInput();
                }
                $a->quantity= $a->quantity- $item->quantity;
                $a->save();
                $d = new StockTransactionDetail();
                $d->stock_transaction_id = $row->id;
                $d->item_id = $item->item_id;
                $d->price = $item->price;
                $d->quantity = $item->quantity;
                $d->new_quantity = $a->quantity;
//                $d->total = $item->quantity * $item->price;
                $d->save();
//
            }

//        $client->roles()->sync($request->input('role'));
            DB::commit();
            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/stock-transaction');


        } catch (\Exception $e) {
            DB::rollBack();
//            dd($e->getMessage());
//            return $e->getMessage();
//            $error = $e->getMessage();
//            $html = view('partials.errors', compact('error'))->render();
//            $data = [
//                'status' => false,
//                'errors' => $html,
//            ];

//            return response()->json($data, 422);
//            flash()->error($e->getMessage());
            return back()->withErrors($e->getMessage())->withInput();
//            return back();


        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();
//            dd(456);
//            $error = $ex->errorInfo[2];
//            $html = view('partials.errors', compact('error'))->render();
//            $data = [
//                'status' => false,
//                'errors' => $html,
//            ];

//            return response()->json($data, 422);
//            flash()->error($ex->errorInfo[2]);

            return back()->withErrors($ex->errorInfo[2])->withInput();

        }
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
        $model = StockTransaction::findOrFail($id);
        return view('admin.stock_transaction.edit', compact('model'));
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

            'unit_id' => 'required|exists:units,id',
            'details' => 'required',
            'quantity' => 'required|numeric|min:0',
            'name' => 'required|unique:stock_transactions,name,' . $id,


        ]);

        $row = StockTransaction::findOrFail($id);
        $row->update($request->all());


//        $client->roles()->sync($request->role);
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/stock-transaction');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $row = StockTransaction::findOrFail($id);


        $row->delete();
        toastr()->success(trans('main.delete_done_successfully'));
        return back();

    }


}
