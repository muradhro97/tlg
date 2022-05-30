<?php

namespace App\Http\Controllers\Admin;

use App\Item;
use App\Safe;

use App\User;
use App\Accounting;
use App\Item_quantity;
use App\SafeTransaction;
use App\StockTransaction;


use App\PusherNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class StockController extends Controller
{
    //
    public function __construct()
    {
//        $this->middleware('permission:accountingRequest', ['only' => ['accountingRequest']]);

    }

    public function accountingRequest(Request $request)
    {

        $rows = Accounting::where('stock_status', 'waiting')
            ->where('manager_status', 'accept')
            ->where('type', 'invoice');

        $user=Auth::user();
        $product_ids=$user->projects()->select('project_id');
        $rows->whereIn('project_id',$product_ids);

        if ($request->filled('project_id')) {
            $rows->where('project_id', $request->project_id);


        }
        if ($request->filled('organization_id')) {
            $rows->where('organization_id', $request->organization_id);


        }
        if ($request->filled('labors_department_id')) {
            $rows->where('labors_department_id', $request->labors_department_id);


        }
        if ($request->filled('employee_id')) {
            $rows->where('employee_id', $request->employee_id);


        }

        if ($request->filled('safe_id')) {
            $rows->where('safe_id', $request->safe_id);


        }

        if ($request->filled('manager_status')) {
            $rows->where('manager_status', $request->manager_status);

        }
        if ($request->filled('payment_status')) {
            $rows->where('payment_status', $request->payment_status);

        }
        if ($request->filled('stock_status')) {
            $rows->where('stock_status', $request->stock_status);

        }




        $rows = $rows->paginate(20);
//        return "asa";
        return view('admin.stock.accounting_request', compact('rows'));
    }


    public function show($id)
    {
//        return "asa";
        $row = Accounting::where('manager_status', 'accept')->where('type', 'invoice')->where('id', $id)->first();
//        return view('admin.stock.show', compact('row'));
        return view('admin.invoice.show', compact('row'));
    }

    public function changeStatus(Request $request)
    {
        DB::beginTransaction();
        try {
//            $row = Accounting::find($request->id);
            $row = Accounting::where('manager_status', 'accept')
                ->where('stock_status', 'waiting')
                ->where('type', 'invoice')->where('id', $request->id)->first();
            $row->stock_status = $request->stock_status;
            $row->save();
            if ($request->stock_status == "confirmed") {
                $details = $row->accountingDetails;
                foreach ($details as $item) {
                    $a = Item::find($item->item_id);
                    $old_quantity = $a->all_item_quantities()->sum('quantity');

                    // create new item quantity that is priced
                    $item_quantity = new Item_quantity([
                        'item_id'=>$a->id,
                        'project_id' => $row->project_id,
                        'quantity' => $item->quantity,
                        'color_id' => $item->color_id,
                        'size_id' =>  $item->size_id,
                        'price' =>    $item->price,
                        'is_priced' => true,
                    ]);
                    $item_quantity->save();

                    $d = new StockTransaction();
                    $d->accounting_id = $row->id;
                    $d->item_id = $item->item_id;
                    $d->price = $item->price;
                    $d->type = "in";
                    $d->module = "accounting";
                    $d->quantity = $item->quantity;
                    $d->old_quantity = $old_quantity;
                    $d->new_quantity = $old_quantity + $item->quantity;
                    $d->save();
                }

                DB::commit();
                toastr()->success(trans('main.confirm_done_successfully'));
                $notifiers = User::permission(['accountantNotification', 'managerNotification'])->get();
                $title = 'Invoice';
                $message = 'Invoice # ' . $row->id . ' accepted by  Stock Employee (' . auth()->user()->name . ')';
                $link = url('admin/invoice/' . $row->id);
                PusherNotification::sendAll($notifiers, $title, $message, $link);
            } elseif ($request->stock_status == "cancel") {
                DB::commit();
                toastr()->success(trans('main.decline_done_successfully'));
                $notifiers = User::permission('managerNotification')->get();

                $title = 'Invoice';
                $message = 'Invoice # ' . $row->id . ' Declined by Stock Employee (' . auth()->user()->name . ')';
                $link = url('admin/invoice/' . $row->id);
                PusherNotification::sendAll($notifiers, $title, $message, $link);
            }


            return back();

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage())->withInput();
//            return back();


        } catch
        (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();


            return back()->withErrors($ex->errorInfo[2])->withInput();

        }

    }


}
