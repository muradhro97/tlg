<?php

namespace App\Http\Controllers\Admin;

use App\Item;
use App\Safe;
use App\User;
use App\Payment;
use App\Employee;

use App\Accounting;
use App\AccountingImage;
use App\SafeTransaction;
use App\AccountingDetail;
use App\StockTransaction;


use App\PusherNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;


class InvoiceController extends Controller
{


    public function __construct()
    {
        $this->middleware('permission:allInvoice', ['only' => ['index']]);
        $this->middleware('permission:addInvoice', ['only' => ['create', 'store']]);
        $this->middleware('permission:addExpense', ['only' => ['createExpense', 'saveExpense']]);
        $this->middleware('permission:detailsInvoice', ['only' => ['show']]);
        $this->middleware('permission:managerAcceptDeclineInvoice', ['only' => ['managerChangeStatus']]);
        $this->middleware('permission:safeAcceptDeclineInvoice', ['only' => ['safeChangeStatus']]);
        $this->middleware('permission:stockAcceptDeclineInvoice', ['only' => ['stockChangeStatus']]);

    }

    public function index(Request $request)
    {
        //
        $user=Auth::user();
        $product_ids=$user->projects()->select('project_id');
        $rows = Accounting::latest()->whereIn('type', ['invoice', 'expense']);
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

        if ($request->filled('type')) {
            $rows->where('type', $request->type);


        }

        $total = $rows->sum('amount');
        $rows = $rows->paginate(20);

        return view('admin.invoice.index', compact('rows', 'total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createExpense(Accounting $model)
    {
//        return "asa";
        return view('admin.invoice.create_expense', compact('model'));
    }

    public function create(Accounting $model)
    {
//        return "asa";
        return view('admin.invoice.create', compact('model'));
    }


    public function store(Request $request)
    {
        //

        $rules = [

            'date' => 'required|date|date_format:Y-m-d',
//            'amount' => 'required|numeric|min:0',
            'organization_id' => 'required|exists:organizations,id',
            'project_id' => 'required|exists:projects,id',
//            'labors_department_id' => 'required|exists:labors_departments,id',
//            'labors_type' => 'required|in:na,all,supervisor,technical,assistant,worker',
        // safe_id required if is_on_custody is null
            'employee_id' => 'required|exists:employees,id',


//            'details' => 'required',
//            'description' => 'required',
//            'images.*' => 'image|mimes:jpg,jpeg,bmp,png',


        ];
        if (is_null($request->is_on_custody))
        {
            $rules['safe_id'] = 'required|exists:safes,id';
        }

        if ($request->images != null and count(array_filter($request->images)) > 0) {
            $rules['images.*'] = 'image|mimes:jpg,jpeg,bmp,png';
//            dd($request->images);
        }
        $validator = validator()->make($request->all(), $rules);


        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();


        }
        DB::beginTransaction();
        try {
            $amount = 0;


            $row = Accounting::create([

                'date' => $request->date,
                'amount' => $amount,
                'organization_id' => $request->organization_id,
                'project_id' => $request->project_id,
                'labors_department_id' => $request->labors_department_id,
                'labors_type' => $request->labors_type,
//                'contract_id' => $request->contract_id,
                'type' => 'invoice',
//                    'module' => 'accounting',
                'safe_id' => is_null($request->is_on_custody) ? $request->safe_id : null,
//                    'extract_no' => $request->extract_no,
                'employee_id' => $request->employee_id,
                'is_on_custody'  => is_null($request->is_on_custody)? 0:1,
                'details' => $request->details,
                'payment_status' => "waiting",
                'manager_status' => "waiting",


            ]);

            $items = json_decode($request->items);
            foreach ($items as $item) {
                $d = new AccountingDetail();
                $d->accounting_id = $row->id;
                $d->item_id = $item->item_id;
                $d->price = $item->price;
                $d->color_id = $item->color_id;
                $d->size_id = $item->size_id;
                $d->quantity = $item->quantity;
                $d->save();
                $amount = $amount + ($item->price * $item->quantity);
            }
            $row->amount = $amount;
            $row->save();

            if ($request->hasFile('images')) {
                $images = $request->file('images');
                foreach ($images as $image) {
                    $this->addImage($image, $row->id, 'uploads/accounting/');

                }
            }
            if (!is_null($request->is_on_custody)) {
                $employee = Employee::find($request->employee_id);
                // update employee custody
                $employee_custody = $employee->custody()->where('status','open')->get();

                // check employee custody bigger than amount
                if ($employee_custody->sum('amount') < $amount) {
                    return back()->withErrors(['amount is bigger than employee custody'])->withInput();
                }

                // update accounting payment_status and manager_status
                $row->payment_status = "confirmed";
                $row->manager_status = "accept";
                $row->save();

                foreach ($employee_custody as $custody) {
                    if ($custody->amount < $amount) {
                        $amount -= $custody->amount;
                        $custody->update([
                            'status' => 'closed',
                        ]);

                    } elseif ($custody->amount == $amount) {
                        $custody->update([
                            'status' => 'closed',
                        ]);
                        break;
                    } elseif ($custody->amount > $amount && $amount > 0) {

                        $payment = Payment::create([
                            'employee_id' => $custody->employee_id,
                            'amount' => $amount,
                            'organization_id' => $custody->organization_id,
                            'project_id' => $custody->project_id,
                            'details' => $custody->details,
                            'type' => 'custody',
                            'status' => 'closed',
                            'date' => $custody->date,
                            'payment_status' => 'paid',
                        ]);

                        $custody->update([
                            'amount' => $custody->amount - $amount
                        ]);
                        break;
                    }
                }
            }

            DB::commit();
            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('New Invoice request id :subject.id  ');
            $notifiers = User::permission('managerNotification')->get();

            $title = 'Invoice';
            $message = 'New Invoice # ' . $row->id . ' Added by (' . auth()->user()->name . ') and needs your Approval ';
            $link = url('admin/invoice/' . $row->id);
            PusherNotification::sendAll($notifiers, $title, $message, $link);

            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/invoice');


        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage())->withInput();
//            return back();


        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();


            return back()->withErrors($ex->errorInfo[2])->withInput();

        }


    }

    public function saveExpense(Request $request)
    {

        $rules = [

            'date' => 'required|date|date_format:Y-m-d',
//            'safe_id' => 'required_if:is_on_custody,null|exists:safes,id',
            'employee_id' => 'required|exists:employees,id',
            'organization_id' => 'required|exists:organizations,id',
            'project_id' => 'required|exists:projects,id',

        ];

        if (is_null($request->is_on_custody))
        {
            $rules['safe_id'] = 'required|exists:safes,id';
        }

        if ($request->images != null and count(array_filter($request->images)) > 0) {
            $rules['images.*'] = 'image|mimes:jpg,jpeg,bmp,png';

        }
        $validator = validator()->make($request->all(), $rules);


        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();


        }
        DB::beginTransaction();
        try {
            $amount = 0;


            $row = Accounting::create([

                'date' => $request->date,
                'amount' => $amount,
                'type' => 'expense',
                'safe_id' => is_null($request->is_on_custody) ? $request->safe_id : null,
                'employee_id' => $request->employee_id,
                'details' => $request->details,
                'payment_status' => "waiting",
                'manager_status' => "waiting",
                'organization_id' => $request->organization_id,
                'project_id' => $request->project_id,
                'is_on_custody'  => is_null($request->is_on_custody)? 0:1,


            ]);


            $items = json_decode($request->items);
            foreach ($items as $item) {


                $d = new AccountingDetail();
                $d->accounting_id = $row->id;
                $d->item_id = $item->expense_item_id;
                $d->item_name = $item->item_name;
                $d->price = $item->price;
                $d->quantity = $item->quantity;
//                $d->new_quantity = $a->quantity;
//                $d->total = $item->quantity * $item->price;
                $d->save();
//
                $amount = $amount + ($item->price * $item->quantity);
            }
            $row->amount = $amount;
            $row->save();
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                foreach ($images as $image) {
                    $this->addImage($image, $row->id, 'uploads/accounting/');

                }
            }

            if (!is_null($request->is_on_custody)) {
                $employee = Employee::find($request->employee_id);
                // update employee custody
                $employee_custody = $employee->custody()->where('status','open')->get();

                // check employee custody bigger than amount
                if ($employee_custody->sum('amount') < $amount) {
                    return back()->withErrors(['amount is bigger than employee custody'])->withInput();
                }
                // update accounting payment_status and manager_status
                $row->payment_status = "confirmed";
                $row->manager_status = "accept";
                $row->save();

                foreach ($employee_custody as $custody) {
                    if ($custody->amount < $amount) {
                        $amount -= $custody->amount;
                        $custody->update([
                            'status' => 'closed',
                        ]);

                    } elseif ($custody->amount == $amount) {
                        $custody->update([
                            'status' => 'closed',
                        ]);
                        break;
                    } elseif ($custody->amount > $amount && $amount > 0) {

                        $payment = Payment::create([
                            'employee_id' => $custody->employee_id,
                            'amount' => $amount,
                            'organization_id' => $custody->organization_id,
                            'project_id' => $custody->project_id,
                            'details' => $custody->details,
                            'type' => 'custody',
                            'status' => 'closed',
                            'date' => $custody->date,
                            'payment_status' => 'paid',
                        ]);

                        $custody->update([
                            'amount' => $custody->amount - $amount
                        ]);
                        break;
                    }
                }
            }


            DB::commit();
            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('New Invoice request id :subject.id  ');

            $notifiers = User::permission('managerNotification')->get();

            $title = 'Invoice';
            $message = 'New Invoice # ' . $row->id . ' Added by (' . auth()->user()->name . ') and needs your Approval ';
            $link = url('admin/invoice/' . $row->id);
            PusherNotification::sendAll($notifiers, $title, $message, $link);

            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/invoice');


        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage())->withInput();
//            return back();


        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();


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

        $row = Accounting::find($id);
        return view('admin.invoice.show', compact('row'));
    }

    public function invoicePrint( $id)
    {
        $row = Accounting::find($id);
        return view('admin.invoice.invoice_print', compact('row'));
    }

    public function managerChangeStatus(Request $request)
    {

        $row = Accounting::find($request->id);
//        $row->payment_status = $request->manager_status;
//        $row->save();
//        return  $request->all();
//        dd(122);
        if ($request->manager_status == "accept") {
            $safe = Safe::find($row->safe_id);
            if ($safe->type == "BankAccount") {
                DB::beginTransaction();
                try {
                    if ($row->amount > $safe->balance) {
                        DB::rollBack();
                        return back()->withErrors(trans('main.amount_bigger_than_safe_balance'))->withInput();
                    }
////                $row = Accounting::find($request->id);
                    $row->manager_status = $request->manager_status;
                    $row->payment_status = "confirmed";
//                    dd($row);
                    $row->save();


                    SafeTransaction::create([

                        'accounting_id' => $row->id,
                        'amount' => $row->amount,
                        'module' => 'accounting',
                        'balance' => $safe->balance,
                        'new_balance' => $safe->balance - $row->amount,
                        'safe_id' => $row->safe_id,


                    ]);
                    $safe->balance = $safe->balance - $row->amount;
                    $safe->save();
                    toastr()->success(trans('main.accept_done_successfully'));


                    DB::commit();
                    activity()
                        ->performedOn($row)
                        ->causedBy(auth()->user())
                        ->log('The Invoice request id :subject.id Manager Accepted ');
                    $notifiers = User::permission('accountantNotification')->get();
                    $title = 'Invoice';
                    $message = 'Invoice # ' . $row->id . ' accepted by manager (' . auth()->user()->name . ')';
                    $link = url('admin/invoice/' . $row->id);
                    PusherNotification::sendAll($notifiers, $title, $message, $link);
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
            $row->manager_status = $request->manager_status;

            $row->save();
            toastr()->success(trans('main.accept_done_successfully'));
            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('The Invoice request id :subject.id Manager Accepted ');

            $notifiers = User::permission('safeNotification')->get();
            $title = 'Invoice';
            $message = 'New Invoice # ' . $row->id . ' Added by (' . auth()->user()->name . ') and needs your Approval ';
            $link = url('admin/accounting/' . $row->id);
            PusherNotification::sendAll($notifiers, $title, $message, $link);

        } elseif ($request->manager_status == "decline") {


            $row->manager_status = $request->manager_status;
            $row->save();
            toastr()->success(trans('main.decline_done_successfully'));
            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('The Invoice request id :subject.id Manager Declined ');
            $notifiers = User::permission('accountantNotification')->get();
            $title = 'Invoice';
            $message = 'Invoice # ' . $row->id . ' Declined by Manager (' . auth()->user()->name . ')';
            $link = url('admin/invoice/' . $row->id);
            PusherNotification::sendAll($notifiers, $title, $message, $link);
        }
        return back();
    }
    //not used
    public function stockChangeStatus(Request $request)
    {
        if ($request->manager_status == "accept") {
            DB::beginTransaction();
            try {

                $row = Accounting::find($request->id);
                $row->payment_status = $request->manager_status;
                $row->save();
                $details = $row->accountingDetails;

                foreach ($details as $item) {
                    $a = Item::find($item->item_id);
                    $old_quantity = $a->all_item_quantities()->sum('quantity');
                    dd($old_quantity);
                    $a->quantity = $a->quantity + $item->quantity;
                    $a->save();
                    $d = new StockTransaction();
                    $d->accounting_id = $row->id;
                    $d->item_id = $item->item_id;
                    $d->price = $item->price;
                    $d->type = "in";
                    $d->module = "accounting";
                    $d->quantity = $item->quantity;
                    $d->old_quantity = $old_quantity;
                    $d->new_quantity = $a->quantity;
                    $d->save();
                }

                DB::commit();
                toastr()->success(trans('main.accept_done_successfully'));
                activity()
                    ->performedOn($row)
                    ->causedBy(auth()->user())
                    ->log('The Invoice request id :subject.id Stock Accepted ');
                $notifiers = User::permission(['accountantNotification', 'managerNotification'])->get();
                $title = 'Invoice';
                $message = 'Invoice # ' . $row->id . ' accepted by  Stock Employee (' . auth()->user()->name . ')';
                $link = url('admin/invoice/' . $row->id);
                PusherNotification::sendAll($notifiers, $title, $message, $link);
            } catch (\Exception $e) {
                DB::rollBack();

                return back()->withErrors($e->getMessage())->withInput();
//            return back();


            } catch (\Illuminate\Database\QueryException $ex) {
                DB::rollBack();


                return back()->withErrors($ex->errorInfo[2])->withInput();

            }
        } elseif ($request->manager_status == "decline") {
            $row = Accounting::find($request->id);
            $row->payment_status = $request->manager_status;
            $row->save();
            toastr()->success(trans('main.decline_done_successfully'));
            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('The Invoice request id :subject.id Stock Declined ');
            $notifiers = User::permission('managerNotification')->get();

            $title = 'Invoice';
            $message = 'Invoice # ' . $row->id . ' Declined by Stock Employee (' . auth()->user()->name . ')';
            $link = url('admin/invoice/' . $row->id);
            PusherNotification::sendAll($notifiers, $title, $message, $link);
        }
        return back();
    }

    public function safeChangeStatus(Request $request)
    {
        DB::beginTransaction();
        try {
            $row = Accounting::find($request->id);
            $row->payment_status = $request->payment_status;
            $row->save();
            $safe = Safe::find($row->safe_id);
            if ($request->payment_status == "confirmed" and $row->is_on_custody == 1)
            {
                // Get Open Employee Custody
                $employee = Employee::find($row->employee_id);
                $open_amount = $employee->custody()->where('status','open')->sum('amount');
                $custody_items = $employee->custody()->where('status','open')->get();

                if ($row->amount > $open_amount) {
                    DB::rollBack();
                    return back()->withErrors(trans('main.amount_bigger_than_employee_custody'))->withInput();
                }

                $invoice_amount = $row->amount;

                foreach ($custody_items as $item)
                {
                    if ($item->amount < $invoice_amount)
                    {
                        $invoice_amount -= $item->amount;
                        $item->update([
                            'status' => 'closed',
                        ]);
                    }
                    elseif ($item->amount == $invoice_amount)
                    {
                        $item->update([
                            'status' => 'closed',
                        ]);
                        break;
                    }
                    elseif ($item->amount > $invoice_amount && $invoice_amount >0)
                    {
                        Payment::create([

                            'date' => $item->date,
                            'amount' => $invoice_amount,
                            'organization_id' => $item->organization_id,
                            'project_id' => $item->project_id,
                            'employee_id' => $item->employee_id,
                            'details' => $item->details,
                            'type' => 'custody',
                            'status' => 'closed',
                            'payment_status' => 'paid',

                        ]);

                        $item->update([
                            'amount' => $item->amount - $invoice_amount
                        ]);
                        break;
                    }
                }

                DB::commit();


                toastr()->success(trans('main.confirm_done_successfully'));
                activity()
                    ->performedOn($row)
                    ->causedBy(auth()->user())
                    ->log('The Invoice request id :subject.id Safe Accepted ');

                $notifiers = User::permission(['accountantNotification', 'managerNotification'])->get();
                $title = 'Invoice';
                $message = 'Invoice # ' . $row->id . ' accepted by  Safe Employee (' . auth()->user()->name . ')';
                $link = url('admin/invoice/' . $row->id);
                PusherNotification::sendAll($notifiers, $title, $message, $link);

            }
            elseif ($request->payment_status == "confirmed" and $safe->type == "safe") {
                if ($row->amount > $safe->balance) {
                    DB::rollBack();
                    return back()->withErrors(trans('main.amount_bigger_than_safe_balance'))->withInput();
                }
                SafeTransaction::create([

                    'accounting_id' => $row->id,
                    'amount' => $row->amount,
                    'module' => 'accounting',
                    'balance' => $safe->balance,
                    'new_balance' => $safe->balance - $row->amount,
                    'safe_id' => $row->safe_id,

                ]);
                $safe->balance = $safe->balance - $row->amount;
                $safe->save();
                DB::commit();


                toastr()->success(trans('main.confirm_done_successfully'));
                activity()
                    ->performedOn($row)
                    ->causedBy(auth()->user())
                    ->log('The Invoice request id :subject.id Safe Accepted ');

                $notifiers = User::permission(['accountantNotification', 'managerNotification'])->get();
                $title = 'Invoice';
                $message = 'Invoice # ' . $row->id . ' accepted by  Safe Employee (' . auth()->user()->name . ')';
                $link = url('admin/invoice/' . $row->id);
                PusherNotification::sendAll($notifiers, $title, $message, $link);
            } elseif ($request->payment_status == "cancel") {
                DB::commit();

                toastr()->success(trans('main.decline_done_successfully'));

                activity()
                    ->performedOn($row)
                    ->causedBy(auth()->user())
                    ->log('The Invoice request id :subject.id Safe Declined ');
                $notifiers = User::permission('managerNotification')->get();

                $title = 'Invoice';
                $message = 'Invoice # ' . $row->id . ' Declined by Safe Employee (' . auth()->user()->name . ')';
                $link = url('admin/invoice/' . $row->id);
                PusherNotification::sendAll($notifiers, $title, $message, $link);
            }


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

    public static function addImage($image, $id, $path)
    {
        $path_thumb = $path . 'thumb_';
        $name = time() . '' . rand(11111, 99999) . '.' . $image->getClientOriginalExtension();
        $img = Image::make($image);

        $img->save($path . $name);

        $img->widen(100, null);

        $img->save($path_thumb . $name);
        $addImage = new AccountingImage();
        $addImage->image = $path . $name;
        $addImage->image_thumb = $path_thumb . $name;
        $addImage->accounting_id = $id;
        $addImage->save();
    }

    public static function deleteImage($name)
    {
        $deletepath = base_path($name);
        if (file_exists($deletepath) and $name != '') {
            unlink($deletepath);
        }

        return true;
    }


}
