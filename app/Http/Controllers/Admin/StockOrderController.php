<?php

namespace App\Http\Controllers\Admin;

use App\Item;
use App\Size;
use App\User;
use App\Color;
use App\Stock;
use App\Payment;
use App\Accounting;
use App\StockOrder;
use App\Item_quantity;
use App\Library\Field;
use App\StockOrderDetail;
use App\StockTransaction;
use App\PusherNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StockOrderController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('permission:stockOrder', ['only' => ['index']]);
        $this->middleware('permission:stockIn', ['only' => ['stockIn', 'storeStockIn']]);
        $this->middleware('permission:stockOut', ['only' => ['stockOut', 'storeStockIn']]);
        $this->middleware('permission:detailsStockOrder', ['only' => ['show']]);
        $this->middleware('permission:acceptStockOrder', ['only' => ['stockAccept']]);
        $this->middleware('permission:declineStockOrder', ['only' => ['stockDecline']]);
        $this->middleware('permission:approveStockOrder', ['only' => ['stockApprove']]);
        $this->middleware('permission:stockOutToLoan', ['only' => ['stockOutToLoan']]);


    }

    public function index(Request $request)
    {
        //

        $rows = StockOrder::latest();

        $user=Auth::user();
        $product_ids=$user->projects()->select('project_id');
        $rows->whereIn('project_id',$product_ids);
        
        if ($request->filled('project_id')) {
            $rows->where('project_id', $request->project_id);


        }
        if ($request->filled('organization_id')) {
            $rows->where('organization_id', $request->organization_id);


        }

        if ($request->filled('employee_id')) {
            $rows->where('employee_id', $request->employee_id);
        }

        if ($request->filled('worker_id')) {
            $rows->where('worker_id', $request->worker_id);
        }


        if ($request->filled('custody_type')) {
            $rows->where('custody_type', $request->custody_type);

        }
        if ($request->filled('stock_type')) {
            $rows->where('stock_type', $request->stock_type);

        }
        if ($request->filled('status')) {
            $rows->where('status', $request->status);

        }

        if ($request->filled('type')) {
            $rows->where('type', $request->type);


        }

        if ($request->filled('date')) {
            $rows->where('date', $request->date);


        }


        $rows = $rows->paginate(20);

        return view('admin.stock_orders.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function stockIn(StockOrder $model)
    {
//        return "asa";
        return view('admin.stock_orders.stock_in', compact('model'));
    }

    public function stockOut(StockTransaction $model)
    {
//        return "asa";
        return view('admin.stock_orders.stock_out', compact('model'));
    }

    public function create(StockTransaction $model)
    {
//        return "asa";
        return view('admin.stock.create', compact('model'));
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
//            'approved_by' => 'required|exists:employees,id',
            'stock_type' => 'required|exists:stock_types,id',


//            'details' => 'required',
            'total' => 'numeric|min:0',

            'type' => 'required|in:in,out',
            'date' => 'required|date|date_format:Y-m-d',
//            'custody_type' => 'required|in:consumed,permanent,refundable',


        ];
        if($request->human_type == 'worker')
        {
            $request->employee_id = null;
        }
        else
        {
            $request->worker_id = null;
        }

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
            $row = StockOrder::create([
//            DB::table('client_transactions')->insert([

                'employee_id' => $request->employee_id,
                'approved_by' => auth()->user()->id,
                'stock_type' => $request->stock_type,
                'details' => $request->details,
                'type' => $request->type,
                'date' => $request->date,
                'total' => $request->total,
                'custody_type' => $request->custody_type,


            ]);
            $items = json_decode($request->items);
            foreach ($items as $item) {
//                $a= Item::find($item->item_id);
//                $a->quantity= $a->quantity+ $item->quantity;
//                $a->save();
                $d = new StockOrderDetail();
                $d->stock_order_id = $row->id;
                $d->item_id = $item->item_id;
                $d->price = $item->price;
                $d->quantity = $item->quantity;
                $d->size = $item->size;
                $d->color = $item->color;
//                $d->new_quantity = $a->quantity;
//                $d->total = $item->quantity * $item->price;
                $d->save();
            }
            DB::commit();
            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('new stock in request id :subject.id ');
//        $client->roles()->sync($request->input('role'));

            $notifiers = User::permission('managerNotification')->get();

            $title = 'Stock';
            $message = 'New Stock in # ' . $row->id . ' Added by (' . auth()->user()->name . ')  and needs your Approval ';
            $link = url('admin/stock-order/' . $row->id);
            PusherNotification::sendAll($notifiers, $title, $message, $link);
            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/stock-order');


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

            'human_type' => 'required|in:employee,worker',
            'employee_id' => 'nullable|required_if:human_type,employee|exists:employees,id',
            'worker_id' => 'nullable|required_if:human_type,worker|exists:workers,id',

//            'approved_by' => 'required|exists:employees,id',
            'stock_type' => 'required|exists:stock_types,id',
//            'details' => 'required',
            'total' => 'numeric|min:0',

            'type' => 'required|in:in,out',
            'date' => 'required|date|date_format:Y-m-d',
            'custody_type' => 'required|in:consumed,permanent,refundable',


        ];
        if($request->human_type == 'worker')
        {
            $request->employee_id = null;
        }
        else
        {
            $request->worker_id = null;
        }

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


        DB::beginTransaction();
        try {
            $row = StockOrder::create([
//            DB::table('client_transactions')->insert([

                'project_id' => $request->project_id,
                'employee_id' => $request->employee_id,
                'worker_id' => $request->worker_id,
                'human_type' => $request->human_type,
                'approved_by' => auth()->user()->id,
                'stock_type' => $request->stock_type,
                'details' => $request->details,
                'type' => $request->type,
                'date' => $request->date,
                'total' => $request->total,
                'custody_type' => $request->custody_type,


            ]);
            $items = json_decode($request->items);
            foreach ($items as $item) {
//                $a= Item::find($item->item_id);
//                if($item->quantity> $a->quantity){
//                    DB::rollBack();
//                    return back()->withErrors($a->name .' item '.trans('main.quantity_bigger_than_stock_quantity'))->withInput();
//                }
//                $a->quantity= $a->quantity- $item->quantity;
//                $a->save();

                //check item quantities
                $item_quantity = Item_quantity::where([
                    'color_id'  =>  $item->color_id,
                    'size_id'  =>  $item->size_id,
                    'item_id'  =>  $item->item_id,
                    'project_id'    =>  $request->project_id,
                ])->sum('quantity');
                if ($item->quantity > $item_quantity)
                {
                    return back()->withErrors(trans('main.quantity_bigger_than_stock_quantity'));
                }

                // make order details from stock (not priced)
                $stock_quantity = Item_quantity::where([
                    'color_id'  =>  $item->color_id,
                    'size_id'  =>  $item->size_id,
                    'item_id'  =>  $item->item_id,
                    'is_priced'  =>  0,
                ])->first();


                if($stock_quantity->quantity >= $item->quantity)
                {
                    $d = new StockOrderDetail();
                    $d->stock_order_id = $row->id;
                    $d->item_quantity_id = $stock_quantity->id;
                    $d->item_id = $item->item_id;
                    $d->price = $item->price;
                    $d->quantity = $item->quantity;
                    $d->size = $item->size;
                    $d->color = $item->color;
                    $d->save();
                    continue;
                }
                elseif ($stock_quantity->quantity > 0)
                {
                    $d = new StockOrderDetail();
                    $d->stock_order_id = $row->id;
                    $d->item_quantity_id = $stock_quantity->id;
                    $d->item_id = $item->item_id;
                    $d->price = $item->price;
                    $d->quantity = $stock_quantity->quantity;
                    $d->size = $item->size;
                    $d->color = $item->color;
                    $d->save();
                    $item->quantity = $item->quantity - $stock_quantity->quantity;
                }

                // make order details from invoice (priced)
                $invoice_quantities =Item_quantity::where([
                    'color_id'  =>  $item->color_id,
                    'size_id'  =>  $item->size_id,
                    'item_id'  =>  $item->item_id,
                    'project_id'    =>  $request->project_id,
                    'is_priced'  =>  1,
                ])->where('quantity','>',0)->get();

                foreach ($invoice_quantities as $invoice_quantity)
                {
                    if($invoice_quantity->quantity >= $item->quantity)
                    {
                        $d = new StockOrderDetail();
                        $d->stock_order_id = $row->id;
                        $d->item_quantity_id = $invoice_quantity->id;
                        $d->item_id = $item->item_id;
                        if ($item->is_manual_price)
                        {
                            $d->price = $item->price;
                            $d->net = ($item->price - $invoice_quantity->price) *$item->quantity;
                        }
                        else
                        {
                            $d->price = $invoice_quantity->price;
                        }
                        $d->quantity = $item->quantity;
                        $d->size = $item->size;
                        $d->color = $item->color;
                        $d->save();
                        break;
                    }
                    else
                    {
                        $d = new StockOrderDetail();
                        $d->stock_order_id = $row->id;
                        $d->item_quantity_id = $invoice_quantity->id;
                        $d->item_id = $item->item_id;
                        if ($item->is_manual_price)
                        {
                            $d->price = $item->price;
                            $d->net = ($item->price - $invoice_quantity->price) *$invoice_quantity->quantity;
                        }
                        else
                        {
                            $d->price = $invoice_quantity->price;
                        }
                        $d->quantity = $invoice_quantity->quantity;
                        $d->size = $item->size;
                        $d->color = $item->color;
                        $d->save();

                        $item->quantity = $item->quantity - $invoice_quantity->quantity;
                    }

                }

            }
            DB::commit();
            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('new stock out request id :subject.id ');
            $notifiers = User::permission('managerNotification')->get();

            $title = 'Stock';
            $message = 'New Stock out # ' . $row->id . ' Added by (' . auth()->user()->name . ')  and needs your Approval ';
            $link = url('admin/stock-order/' . $row->id);
            PusherNotification::sendAll($notifiers, $title, $message, $link);
//        $client->roles()->sync($request->input('role'));
            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/stock-order');


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

    public function show(Request $request, $id)
    {

        if ($request->filled('notification')) {
            $notification = auth()->user()->unreadNotifications()->where('id', $request->notification)->first();
            if ($notification) {

                $notification->markAsRead();
            }
        }

        $row = StockOrder::find($id);
        return view('admin.stock_orders.show', compact('row'));
    }

    public function stockAccept(Request $request)
    {

        $row = StockOrder::find($request->id);
        $row->status = "accept";
        $row->save();
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The stock in request id :subject.id  accepted');
        $notifiers = User::permission('stockNotification')->get();

        $title = 'Stock';
        $message = 'New Stock  '. $row->type.' # ' . $row->id . ' Accepted by (' . auth()->user()->name . ')  and needs your Approval ';
        $link = url('admin/stock-order/' . $row->id);
        PusherNotification::sendAll($notifiers, $title, $message, $link);
        toastr()->success(trans('main.accept_done_successfully'));

        return back();

    }

    public function stockDecline(Request $request)
    {

        $row = StockOrder::find($request->id);
        $row->status = "cancel";
        $row->save();
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The stock in request id :subject.id  declined');
        $notifiers = User::permission('stockNotification')->get();

        $title = 'Stock';
        $message = 'New Stock  '. $row->type.' # ' . $row->id . ' Declined by (' . auth()->user()->name . ')   ';
        $link = url('admin/stock-order/' . $row->id);
        PusherNotification::sendAll($notifiers, $title, $message, $link);
        toastr()->success(trans('main.decline_done_successfully'));

        return back();

    }

    public function stockApprove(Request $request)
    {

//return $request->all();

//        $row = StockOrder::find($request->id);
//   return     $details = $row->stockDetails;
        DB::beginTransaction();
        try {
            $row = StockOrder::find($request->id);
            $row->status = "approve";
            $row->save();
            $details = $row->stockDetails;
            if ($request->type == "in") {
                foreach ($details as $item) {
                    $a = Item::find($item->item_id);
                    //check item quantities
                    $color_id = Color::where('color',$item->color)->first()->id;
                    $size_id = Size::where('size',$item->size)->first()->id;
                    $item_quantity = Item_quantity::where([
                        'color_id'  =>  $color_id,
                        'size_id'  =>  $size_id,
                        'item_id'  =>  $item->item_id,
                    ])->first();
                    if (is_null($item_quantity))
                    {
                        $item_quantity = Item_quantity::create([
                            'color_id'  =>  $color_id,
                            'size_id'  =>  $size_id,
                            'item_id'  =>  $item->item_id,
                        ]);
                    }
                    /*-----------------*/
                    $old_quantity = $item_quantity->quantity;
                    $item_quantity->quantity = $item_quantity->quantity + $item->quantity;
                    $item_quantity->save();
                    $d = new StockTransaction();
                    $d->stock_order_id = $row->id;
                    $d->item_id = $item->item_id;
                    $d->price = $item->price;
                    $d->type = $row->type;
                    $d->quantity = $item->quantity;
                    $d->old_quantity = $old_quantity;
                    $d->new_quantity = $item_quantity->quantity;
                    $d->save();
                }
            } elseif ($request->type == "out") {
                foreach ($details as $item) {
                    $a = Item::find($item->item_id);
                    $item_quantity = Item_quantity::find($item->item_quantity_id);
                    if (is_null($item_quantity))
                    {
                        return back()->withErrors('Item Quantity Not Available');
                    }
                    if ($item->quantity > $item_quantity->quantity)
                    {
                        DB::rollBack();
                        return back()->withErrors($a->name . ' item ' . trans('main.quantity_bigger_than_stock_quantity'))->withInput();
                    }
                    /*-----------------*/
                    $old_quantity = $item_quantity->quantity;
                    $item_quantity->quantity = $item_quantity->quantity - $item->quantity;
                    $item_quantity->save();
                    $d = new StockTransaction();
                    $d->stock_order_id = $row->id;
                    $d->item_id = $item->item_id;
                    $d->price = $item->price;
                    $d->net = $item->net;
                    $d->type = $row->type;
                    $d->quantity = $item->quantity;
                    $d->old_quantity = $old_quantity;
                    $d->new_quantity = $item_quantity->quantity;
//                $d->total = $item->quantity * $item->price;
                    $d->save();
//
                }
            }

            DB::commit();
            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('The stock in request id :subject.id  approved');

            $notifiers = User::permission(['accountantNotification', 'managerNotification'])->get();

            $title = 'Stock';
            $message = 'New Stock  '. $row->type.' # ' . $row->id . ' Approved by (' . auth()->user()->name . ')   ';
            $link = url('admin/stock-order/' . $row->id);
            PusherNotification::sendAll($notifiers, $title, $message, $link);
            toastr()->success(trans('main.pay_done_successfully'));
            return back();


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


//        return view('admin.payment.show', compact('row'));
    }

    public function stockOutToLoan($id){
        $stock_order = StockOrder::where('id', $id)->first();
        if ($stock_order->status != 'approve' or $stock_order->is_to_loan) {
            return back();
        }
        DB::beginTransaction();
        try {

            $stock_order->update([
                'is_to_loan'    =>  1,
            ]);

            $row = Accounting::create([

                'date' => now(),
                'amount' => $stock_order->total,
                'type' => is_null($stock_order->worker_id)?'employeeLoan':'workerLoan',
                'safe_id' => 0,
                'employee_id' => $stock_order->employee_id,
                'worker_id' => $stock_order->worker_id,
                'details' => $stock_order->details,
                'payment_status' => "confirmed",
                'manager_status' => "accept",
                'is_was_stock_out' => 1,
            ]);


            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('Employee StockOut to Loan request id :subject.id');


            DB::commit();

            toastr()->success(trans('main.save_done_successfully'));
            return back();


        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage())->withInput();
//            return back();


        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();
            return back()->withErrors($ex->errorInfo[2])->withInput();

        }
    }
}
