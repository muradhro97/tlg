<?php

namespace App\Http\Controllers\Admin;

use App\AccountingEmployeeSalaryDetail;
use App\AccountingImage;

use App\Employee;
use App\EmployeeMonthlyEvaluation;
use App\Http\Controllers\Controller;
use App\Accounting;
use App\Penalty;
use App\PusherNotification;
use App\Safe;
use App\SafeTransaction;

use App\EmployeeTimeSheet;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;


class EmployeeSalaryController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('permission:allEmployeeSalary', ['only' => ['index']]);
        $this->middleware('permission:addEmployeeSalary', ['only' => ['create', 'store']]);
        $this->middleware('permission:detailsEmployeeSalary', ['only' => ['show']]);
        $this->middleware('permission:managerAcceptDeclineEmployeeSalary', ['only' => ['managerChangeStatus']]);
        $this->middleware('permission:safeAcceptDeclineEmployeeSalary', ['only' => ['safeChangeStatus']]);

    }

    public function index(Request $request)
    {
        //

        $rows = Accounting::latest()->where('type', 'employeeSalary');

        if ($request->filled('safe_id')) {
            $rows->where('safe_id', $request->safe_id);


        }

        if ($request->filled('manager_status')) {
            $rows->where('manager_status', $request->manager_status);


        }
        if ($request->filled('payment_status')) {
            $rows->where('payment_status', $request->payment_status);


        }

        $rows = $rows->paginate(20);

        return view('admin.employee_salary.index', compact('rows'));
    }


    public function create(Request $request)
    {
//        return "asa";
        $model = new Accounting();
        $projects = auth()->user()->projects->pluck('id')->toArray();

        if ($request->filled('from') and $request->filled('to')) {

            $from = Carbon::parse($request->from);
            $to = Carbon::parse($request->to);
            if ($from->greaterThan($to)) {
                return back()->withErrors(trans('main.from_date_must_be_greater_than_to_date'))->withInput();
            }

            $rows = Employee::latest()
                ->whereIn('project_id', $projects);
            if ($request->filled('project_id')) {
                $rows->where('project_id', $request->project_id);
            }

            if ($request->filled('organization_id')) {
                $rows->where('organization_id', $request->organization_id);
            }

            if ($request->filled('department_id')) {
                $rows->where('department_id', $request->department_id);
            }

            if ($request->filled('job_id')) {
                $rows->where('job_id', $request->job_id);
            }

//             $rows->whereHas('employeeTimeSheet', function ($q) use ($date) {
// //                $q->whereMonth('date', [$from, $to])->whereNull('accounting_id');
//                 $q->whereMonth('date', Carbon::parse($date))
//                     ->whereYear('date', Carbon::parse($date))
//                     ->whereNull('accounting_id')->where('attendance', '!=', 'no');
//             });

            $rows->whereHas('employeeTimeSheet', function ($q) use ($from, $to) {
                $q->whereBetween('date', [$from, $to])->whereNull('accounting_id')->where('attendance', '!=', 'no');
            });

            $rows = $rows->get();
//            $days = $from->diffInDays($to) + 1;
//              return  $days = Carbon::parse($request->to)->diffInDays($request->from);
//            foreach ($rows as $row) {
//                $row->days = $days;
//            }

        } else {
            $rows = collect();
        }
//return $rows;

        return view('admin.employee_salary.create', compact('model', 'rows'));
    }


    public function store(Request $request)
    {

        $rules = [

            'date' => 'required|date',
            'date_to' => 'required|date',
//            'amount' => 'required|numeric|min:0',
            'safe_id' => 'required|exists:safes,id',
        ];

        $validator = validator()->make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $validator->after(function ($validator) use ($request) {
            if ($request->ids) {

                if (count($request->ids) < 1) {
                    $validator->errors()->add('ids', trans('main.please_add_employee'));
                }
            } else {
                $validator->errors()->add('ids', trans('main.please_add_employee'));
            }

        });
        DB::beginTransaction();
        try {
            $row = Accounting::create([

                'date' => Carbon::parse($request->date_to),
                'start' => $request->date,
                'end' => $request->date_to,
//                'amount' => $request->amount,
                'type' => 'employeeSalary',
//                    'module' => 'accounting',
                'safe_id' => $request->safe_id,
                'details' => $request->details,
                'payment_status' => "waiting",
                'manager_status' => "waiting",
            ]);

            $date = Carbon::parse($request->date);
            $date_to = Carbon::parse($request->date_to);
//            $start = Carbon::parse($request->start);
//            $end = Carbon::parse($request->end);
//            $days = $start->diffInDays($end) + 1;
            $projects = auth()->user()->projects->pluck('id')->toArray();
            $employees = Employee::latest()
                ->whereIn('id', $request->ids)
                ->whereIn('project_id', $projects);
            $employees->whereHas('employeeTimeSheet', function ($q) use ($date,$date_to) {
                $q->whereBetween('date', [$date,$date_to])
                    ->whereNull('accounting_id');

            });

            $employees = $employees->paginate(100);

            $sum_net = 0;
            foreach ($employees as $employee) {
                $timesheet = $employee->employeeTimeSheet()->where('attendance', '!=', 'no')->whereBetween('date', [$date,$date_to])->whereNull('accounting_id')->get();
                $penalty = $employee->penalty()->whereBetween('date', [$date,$date_to])->whereNull('accounting_id')->sum('amount');
                $allowances = $employee->meals + $employee->communications + $employee->transports;
                $deductions = $penalty + $employee->taxes + $employee->insurance;

                $total = $employee->employeeTimeSheet()->where('attendance', '!=', 'no')->whereBetween('date', [$date,$date_to])->whereNull('accounting_id')->sum('total_daily');
                $rewards = $employee->employeeTimeSheet()->where('attendance', '!=', 'no')->whereBetween('date', [$date,$date_to])->whereNull('accounting_id')->sum('reward');

                $loans = $employee->loans()->whereMonth('date', '<=', $date_to)->whereNull('accounting_id')->sum('amount');

                if ($request->loans[$employee->id] > $loans || $request->loans[$employee->id] < 0) {
                    throw new \ErrorException('Max Loan Of ' . $employee->name . ' is ' . $loans);
                }

                $loans_request = $request->loans[$employee->id];

                $monthly_evaluation = $employee->employeeMonthlyEvaluation()->whereBetween('date', [$date,$date_to])->whereNull('accounting_id')->sum('amount');

                $net = $total + $rewards + $allowances - $deductions - $loans_request + $monthly_evaluation;
                $sum_net += $net;

                AccountingEmployeeSalaryDetail::create([

                    'employee_id' => $employee->id,
                    'accounting_id' => $row->id,
                    'days' => $timesheet->count(),
                    'hourly_salary' => $employee->hourly_salary,
                    'total_regular_minutes' => $timesheet->sum('total_regular_minutes'),
                    'total_regular' => $timesheet->sum('total_regular'),
                    'overtime_minutes' => $timesheet->sum('overtime_minutes'),
                    'overtime' => $timesheet->sum('overtime'),
                    'total_daily_minutes' => $timesheet->sum('total_daily_minutes'),
                    'total_daily' => $timesheet->sum('total_daily'),
                    'meals' => $employee->meals,
                    'communications' => $employee->communications,
                    'transports' => $employee->transports,
                    'penalties' => $penalty,
                    'taxes' => $employee->taxes,
                    'insurance' => $employee->insurance,
                    'loans' => $loans_request,
                    'monthly_evaluations' => $monthly_evaluation,
                    'allowances' => $allowances,
                    'deductions' => $deductions,
                    'rewards' => $rewards,
                    'net' => $net,

                ]);
                $employee->employeeTimeSheet()->where('attendance', '!=', 'no')->whereBetween('date', [$date,$date_to])->whereNull('accounting_id')->update([
                    'accounting_id' => $row->id,
                ]);

                $employee->employeeMonthlyEvaluation()->whereBetween('date', [$date,$date_to])->whereNull('accounting_id')->update([
                    'accounting_id' => $row->id,
                ]);

                $employee->penalty()->whereBetween('date', [$date,$date_to])->whereNull('accounting_id')->update([
                    'accounting_id' => $row->id,
                ]);

                // update employee loans
                $employee_loans = $employee->loans()->whereMonth('date', '<=', $date_to)->whereNull('accounting_id')->get();

                foreach ($employee_loans as $employee_loan) {
                    if ($employee_loan->amount < $loans_request) {
                        $loans_request -= $employee_loan->amount;
                        $employee_loan->update([
                            'accounting_id' => $row->id,
                        ]);

                    } elseif ($employee_loan->amount == $loans_request) {
                        $employee_loan->update([
                            'accounting_id' => $row->id,
                        ]);
                        break;
                    } elseif ($employee_loan->amount > $loans_request && $loans_request > 0) {
                        Accounting::create([

                            'date' => $employee_loan->date,
                            'amount' => $loans_request,
                            'type' => 'employeeLoan',
                            'safe_id' => $employee_loan->safe_id,
                            'employee_id' => $employee->id,
                            'payment_status' => "confirmed",
                            'manager_status' => "accept",
                            'accounting_id' => $row->id,

                        ]);

                        $employee_loan->update([
                            'amount' => $employee_loan->amount - $loans_request
                        ]);
                        break;
                    }
                }
//                $employee->loans()->whereMonth('date','<=',$date)->whereNull('accounting_id')->update([
//                    'accounting_id' => $row->id,
//                ]);

            }
            $row->amount = $sum_net;
            $row->save();
            DB::commit();
            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('New Employee Salary request id :subject.id  ');
            $notifiers = User::permission('managerNotification')->get();
            $title = 'Employee salary';
            $message = 'New Employee Salary # ' . $row->id . ' Added by (' . auth()->user()->name . ') and needs your Approval ';
            $link = url('admin/employee-salary/' . $row->id);
            PusherNotification::sendAll($notifiers, $title, $message, $link);


            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/employee-salary');


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
        $row = Accounting::where('id', $id)->where('type', 'employeeSalary')->first();
        return view('admin.employee_salary.show', compact('row'));
    }

    public function detailsPrint($id)
    {


        $row = Accounting::find($id);
        return view('admin.employee_salary.details_print', compact('row'));
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
                        ->log('The Employee Salary request id :subject.id Manager Accepted ');
                    $notifiers = User::permission('accountantNotification')->get();
                    $title = 'Employee salary';
                    $message = 'Employee Salary # ' . $row->id . ' accepted by manager (' . auth()->user()->name . ')';
                    $link = url('admin/employee-salary/' . $row->id);
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
                ->log('The Employee Salary request id :subject.id Manager Accepted ');

            $notifiers = User::permission('safeNotification')->get();
            $title = 'employee salary';
            $message = 'New Employee Salary # ' . $row->id . ' Added by (' . auth()->user()->name . ') and needs your Approval ';
            $link = url('admin/accounting/' . $row->id);
            PusherNotification::sendAll($notifiers, $title, $message, $link);


        } elseif ($request->manager_status == "decline") {
            $row->manager_status = $request->manager_status;
            $row->save();
            EmployeeTimeSheet::where('accounting_id', $row->id)->update(['accounting_id' => null]);
            EmployeeMonthlyEvaluation::where('accounting_id', $row->id)->update(['accounting_id' => null]);
            Penalty::where('accounting_id', $row->id)->update(['accounting_id' => null]);
            Accounting::where('accounting_id', $row->id)->where('type', 'employeeLoan')->where('payment_status', 'confirmed')->update(['accounting_id' => null]);

            toastr()->success(trans('main.decline_done_successfully'));
            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('The Employee Salary request id :subject.id Manager Declined ');

            $notifiers = User::permission('accountantNotification')->get();
            $title = 'Employee salary';
            $message = 'Employee Salary # ' . $row->id . ' Declined by Manager (' . auth()->user()->name . ')';
            $link = url('admin/employee-salary/' . $row->id);
            PusherNotification::sendAll($notifiers, $title, $message, $link);
        }
        return back();
    }


    public function safeChangeStatus(Request $request)
    {
//        return "asa";
        DB::beginTransaction();
        try {
            $row = Accounting::find($request->id);

            $safe = Safe::find($row->safe_id);

            if ($request->payment_status == "confirmed" and $safe->type == "safe") {
                $row->payment_status = $request->payment_status;
                $row->save();
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
                    ->log('The Employee Salary request id :subject.id Safe Accepted ');
                $notifiers = User::permission(['accountantNotification', 'managerNotification'])->get();
                $title = 'Employee salary';
                $message = 'Employee Salary # ' . $row->id . ' accepted by  Safe Employee (' . auth()->user()->name . ')';
                $link = url('admin/employee-salary/' . $row->id);
                PusherNotification::sendAll($notifiers, $title, $message, $link);
            } elseif ($request->payment_status == "cancel") {
                $row->payment_status = $request->payment_status;
                $row->save();
                EmployeeTimeSheet::where('accounting_id', $row->id)->update(['accounting_id' => null]);
                EmployeeMonthlyEvaluation::where('accounting_id', $row->id)->update(['accounting_id' => null]);
                Penalty::where('accounting_id', $row->id)->update(['accounting_id' => null]);
                Accounting::where('accounting_id', $row->id)->where('type', 'employeeLoan')->where('payment_status', 'confirmed')->update(['accounting_id' => null]);

                DB::commit();
                toastr()->success(trans('main.decline_done_successfully'));
                activity()
                    ->performedOn($row)
                    ->causedBy(auth()->user())
                    ->log('The Employee Salary request id :subject.id Safe Declined ');
                $notifiers = User::permission('managerNotification')->get();
                $title = 'Employee salary';
                $message = 'Employee Salary # ' . $row->id . ' Declined by Safe Employee (' . auth()->user()->name . ')';
                $link = url('admin/employee-salary/' . $row->id);
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
