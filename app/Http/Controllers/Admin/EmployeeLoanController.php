<?php

namespace App\Http\Controllers\Admin;

use App\AccountingImage;
use App\Http\Controllers\Controller;
use App\Accounting;
use App\Notifications\TlgNotification;
use App\PusherNotification;
use App\Safe;
use App\SafeTransaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Intervention\Image\Facades\Image;

class EmployeeLoanController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('permission:allEmployeeLoan', ['only' => ['index']]);
        $this->middleware('permission:addEmployeeLoan', ['only' => ['create', 'store']]);
        $this->middleware('permission:detailsEmployeeLoan', ['only' => ['show']]);
        $this->middleware('permission:managerAcceptDeclineEmployeeLoan', ['only' => ['managerChangeStatus']]);
        $this->middleware('permission:safeAcceptDeclineEmployeeLoan', ['only' => ['safeChangeStatus']]);

    }
    public function index(Request $request)
    {
        //

        $rows = Accounting::orderBy('date','desc')->orderBy('created_at','desc')->where('type','employeeLoan');
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

        if ($request->filled('date')) {
            $rows->where('date', $request->date);
        }

        $rows = $rows->paginate(20);

        return view('admin.employee_loan.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Accounting $model)
    {
//        return "asa";
        return view('admin.employee_loan.create', compact('model'));
    }


    public function store(Request $request)
    {


        $rules = [


            'date' => 'required|date|date_format:Y-m-d',

            'amount' => 'required|numeric|min:0',

            'safe_id' => 'required|exists:safes,id',

            'employee_ids' => 'required|exists:employees,id',


        ];


        $validator = validator()->make($request->all(), $rules);


        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();


        }
        DB::beginTransaction();
        try {

            foreach ($request->employee_ids as $item)
            {
                $row = Accounting::create([

                    'date' => $request->date,
                    'amount' => $request->amount,
                    'type' => 'employeeLoan',
                    'safe_id' => $request->safe_id,
                    'employee_id' => $item,
                    'details' => $request->details,
                    'payment_status' => "waiting",
                    'manager_status' => "waiting",

                ]);

                activity()
                    ->performedOn($row)
                    ->causedBy(auth()->user())
                    ->log('New Employee Loan request id :subject.id  ');

                $notifiers = User::permission('managerNotification')->get();

                $title = 'Employee loan';
                $message ='New Employee Loan # '. $row->id .' Added by ('.auth()->user()->name.') and needs your Approval ';
                $link = url('admin/employee-loan/' . $row->id);
                PusherNotification::sendAll($notifiers, $title, $message, $link);
            }
            DB::commit();

            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/employee-loan');


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
//        return "asa";
        $row = Accounting::find($id);
        return view('admin.employee_loan.show', compact('row'));
    }


    public function managerChangeStatus(Request $request)
    {

        $row = Accounting::find($request->id);
//        $row->payment_status = $request->manager_status;
//        $row->save();
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
                    $row->payment_status ="confirmed";
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
                        ->log('The Employee Loan request id :subject.id Manager Accepted ');

                    $notifiers = User::permission('accountantNotification')->get();

                    $title = 'Employee loan';
                    $message = 'Employee Loan # ' . $row->id .' accepted by manager (' . auth()->user()->name.')';
                    $link = url('admin/employee-loan/' . $row->id);
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

            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('The Employee Loan request id :subject.id Manager Accepted ');
            $notifiers = User::permission('safeNotification')->get();

            $title = 'employee loan';
            $message = 'New Employee Loan # '. $row->id .' Added by ('.auth()->user()->name.') and needs your Approval ';
            $link = url('admin/accounting/' . $row->id);
            PusherNotification::sendAll($notifiers, $title, $message, $link);
            toastr()->success(trans('main.accept_done_successfully'));
        } elseif ($request->manager_status == "decline") {
            $row->manager_status = $request->manager_status;
            $row->payment_status = 'cancel';
            $row->save();

            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('The Employee Loan request id :subject.id Manager Declined ');

            $notifiers = User::permission('accountantNotification')->get();

            $title = 'Employee loan';
            $message = 'Employee Loan # ' . $row->id .' Declined by Manager (' . auth()->user()->name.')';
            $link = url('admin/employee-loan/' . $row->id);
            PusherNotification::sendAll($notifiers, $title, $message, $link);

            toastr()->success(trans('main.decline_done_successfully'));
        }
        return back();
    }

    public function managerChangeStatuses(Request $request)
    {
        foreach ($request->ids as $request_id) {
            $request->id = $request_id;
            $row = Accounting::find($request->id);
//        $row->payment_status = $request->manager_status;
//        $row->save();
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
                            ->log('The Employee Loan request id :subject.id Manager Accepted ');

                        $notifiers = User::permission('accountantNotification')->get();

                        $title = 'Employee loan';
                        $message = 'Employee Loan # ' . $row->id . ' accepted by manager (' . auth()->user()->name . ')';
                        $link = url('admin/employee-loan/' . $row->id);
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

                activity()
                    ->performedOn($row)
                    ->causedBy(auth()->user())
                    ->log('The Employee Loan request id :subject.id Manager Accepted ');
                $notifiers = User::permission('safeNotification')->get();

                $title = 'employee loan';
                $message = 'New Employee Loan # ' . $row->id . ' Added by (' . auth()->user()->name . ') and needs your Approval ';
                $link = url('admin/accounting/' . $row->id);
                PusherNotification::sendAll($notifiers, $title, $message, $link);
                toastr()->success(trans('main.accept_done_successfully'));
            } elseif ($request->manager_status == "decline") {
                $row->manager_status = $request->manager_status;
                $row->payment_status = 'cancel';
                $row->save();

                activity()
                    ->performedOn($row)
                    ->causedBy(auth()->user())
                    ->log('The Employee Loan request id :subject.id Manager Declined ');

                $notifiers = User::permission('accountantNotification')->get();

                $title = 'Employee loan';
                $message = 'Employee Loan # ' . $row->id . ' Declined by Manager (' . auth()->user()->name . ')';
                $link = url('admin/employee-loan/' . $row->id);
                PusherNotification::sendAll($notifiers, $title, $message, $link);

                toastr()->success(trans('main.decline_done_successfully'));
            }
        }
        return back();
    }



    public function safeChangeStatus(Request $request)
    {
//        return "asa";
        DB::beginTransaction();
        try {
            $row = Accounting::find($request->id);
            $row->payment_status = $request->payment_status;
            $row->save();
            $safe = Safe::find($row->safe_id);

            if ($request->payment_status == "confirmed" and $safe->type == "safe") {
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
                    ->log('The Employee Loan request id :subject.id Safe Accepted ');
                $notifiers = User::permission(['accountantNotification','managerNotification'])->get();

                $title = 'Employee loan';
                $message = 'Employee Loan # ' . $row->id .' accepted by  Safe Employee (' . auth()->user()->name.')';
                $link = url('admin/employee-loan/' . $row->id);
                PusherNotification::sendAll($notifiers, $title, $message, $link);

            } elseif ($request->payment_status == "cancel") {
                DB::commit();
                toastr()->success(trans('main.decline_done_successfully'));

                activity()
                    ->performedOn($row)
                    ->causedBy(auth()->user())
                    ->log('The Employee Loan request id :subject.id Safe Declined ');
                $notifiers = User::permission('managerNotification')->get();

                $title = 'Employee loan';
                $message = 'Employee Loan # ' . $row->id .' Declined by Safe Employee (' . auth()->user()->name.')';
                $link = url('admin/employee-loan/' . $row->id);
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





}
