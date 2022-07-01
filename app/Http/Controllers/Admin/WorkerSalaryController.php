<?php

namespace App\Http\Controllers\Admin;

use App\AccountingImage;
use App\AccountingWorkerSalaryDetail;
use App\Exports\WorkerSalariesExport;
use App\Http\Controllers\Controller;
use App\Accounting;
use App\PusherNotification;
use App\Safe;
use App\SafeTransaction;
use App\User;
use App\Worker;
use App\WorkerTimeSheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;


class WorkerSalaryController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('permission:allWorkerSalary', ['only' => ['index']]);
        $this->middleware('permission:addWorkerSalary', ['only' => ['create', 'store']]);
        $this->middleware('permission:detailsWorkerSalary', ['only' => ['show']]);
        $this->middleware('permission:managerAcceptDeclineWorkerSalary', ['only' => ['managerChangeStatus']]);
        $this->middleware('permission:safeAcceptDeclineWorkerSalary', ['only' => ['safeChangeStatus']]);

    }

    public function exportExcel()
    {
        $response =  Excel::download(new WorkerSalariesExport(), 'worker_salaries.xlsx');
        ob_end_clean();
        return $response;
    }

    public function index(Request $request)
    {
        //

        $rows = Accounting::latest()->where('type', 'workerSalary');
        if ($request->filled('safe_id')) {
            $rows->where('safe_id', $request->safe_id);
        }

        if ($request->filled('amount')) {
            $rows->where('amount', $request->amount);
        }

        if ($request->filled('from')) {
            $rows->where('start', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $rows->where('end', '<=', $request->to);
        }

        if ($request->filled('manager_status')) {
            $rows->where('manager_status', $request->manager_status);


        }
        if ($request->filled('payment_status')) {
            $rows->where('payment_status', $request->payment_status);


        }

        $total = $rows->sum('amount');
        $rows = $rows->paginate(20);

        return view('admin.worker_salary.index', compact('rows', 'total'));
    }



    public function create(Request $request)
    {
        $model = new Accounting();
        $projects = auth()->user()->projects->pluck('id')->toArray();
        if ($request->filled('from') and $request->filled('to')) {

            $from = Carbon::parse($request->from);
            $to = Carbon::parse($request->to);
            if ($from->greaterThan($to)) {
                return back()->withErrors(trans('main.from_date_must_be_greater_than_to_date'))->withInput();
            }
            $rows = Worker::latest()
//                ->where('working_status', 'work')
                ->whereIn('project_id', $projects);
            if ($request->filled('project_id')) {
                $rows->where('project_id', $request->project_id);
            }
            if ($request->filled('organization_id')) {
                $rows->where('organization_id', $request->organization_id);
            }
            if ($request->filled('job_id')) {
                $rows->where('job_id', $request->job_id);
            }
            if ($request->filled('labors_group_id')) {
                $rows->where('labors_group_id', $request->labors_group_id);
            }

            $rows->whereHas('workerTimeSheet', function ($q) use ($from, $to,$request) {
                $q = $q->whereBetween('date', [$from, $to])->whereNull('accounting_id')
//                    ->where('attendance', 'yes')
                ;
                if ($request->filled('type')){
                    $q->where('type', $request->type);
                }
            });
            $rows = $rows->get();
            $days = $from->diffInDays($to) + 1;
//              return  $days = Carbon::parse($request->to)->diffInDays($request->from);
            foreach ($rows as $row) {
                $row->days = $days;
            }
        } else {
            $rows = collect();
        }

        return view('admin.worker_salary.create', compact('model', 'rows'));
    }


    public function store(Request $request)
    {
        $rules = [
            'start' => 'required|date|date_format:Y-m-d',
            'end' => 'required|date|date_format:Y-m-d|after_or_equal:start',
//            'amount' => 'required|numeric|min:0',
            'safe_id' => 'required|exists:safes,id',
//            'worker_id' => 'required|exists:workers,id',
        ];


        $validator = validator()->make($request->all(), $rules);


        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();


        }

        $validator->after(function ($validator) use ($request) {
            if ($request->ids) {

                if (count($request->ids) < 1) {

                    $validator->errors()->add('ids', trans('main.please_add_worker'));
                }
            } else {
                $validator->errors()->add('ids', trans('main.please_add_worker'));

            }

        });
        DB::beginTransaction();
        try {


            $row = Accounting::create([
                'start' => $request->start,
                'end' => $request->end,
//                'amount' => $request->amount,
                'type' => 'workerSalary',
//                    'module' => 'accounting',
                'safe_id' => $request->safe_id,
//                'worker_id' => $request->worker_id,
                'details' => $request->details,
                'payment_status' => "waiting",
                'manager_status' => "waiting",
            ]);
            $start = Carbon::parse($request->start);
            $end = Carbon::parse($request->end);
//            $days = $start->diffInDays($end) + 1;
            $projects = auth()->user()->projects->pluck('id')->toArray();
            $workers = Worker::latest()
//                ->where('working_status', 'work')
                ->whereIn('id', $request->ids)
                ->whereIn('project_id', $projects);
            $workers->whereHas('workerTimeSheet', function ($q) use ($start, $end,$request) {
                $q = $q->whereBetween('date', [$start, $end])->whereNull('accounting_id');
                if ($request->filled('type')){
                    $q->where('type', $request->type);
                }
            });

            $workers = $workers->paginate(100);
            $sum_net = 0;
            foreach ($workers as $worker) {
                $timesheet = $worker->workerTimeSheet()
//                    ->where('attendance', 'yes')
                    ->whereBetween('date', [$request->start, $request->end])
                    ->whereNull('accounting_id');
                if ($request->filled('type')){
                    $timesheet = $timesheet->where('type', $request->type);
                }
//                $timesheet = $timesheet->get();
                // Apply salary change to timesheet if salary changed
                if (isset($request->salary_changed) && $request->salary_changed == 'on') {
                    $hourly_salary = $worker->job->hourly_salary;
                    $daily_salary = $worker->job->daily_salary;
                    if (!$hourly_salary) {
                        DB::rollBack();
                        return back()->withErrors(trans('main.please_enter_worker_hourly_salary_first'))->withInput();
                    }
                    if (!$daily_salary) {
                        DB::rollBack();
                        return back()->withErrors(trans('main.please_enter_worker_daily_salary_first'))->withInput();
                    }
                    foreach ($timesheet->get() as $item) {
                        if ($item->type == 'productivity')
                        {
                            continue;
                        }
                        if ($item->attendance == "yes") {
                            $additions = ($item->overtime+$item->additional_overtime) * $hourly_salary;
                            $discounts = (($item->deduction_hrs + $item->safety) * $hourly_salary) + $item->deduction_value;
                            $total = $daily_salary + $additions - $discounts;
                        } else {
                            $additions = ($item->overtime+$item->additional_overtime) * $hourly_salary;
                            $discounts = (($item->deduction_hrs + $item->safety) * $hourly_salary) + $item->deduction_value;
                            $total = $additions - $discounts;
                        }
                        $item->update([
                            'hourly_salary' => $hourly_salary,
                            'daily_salary' => $daily_salary,
                            'additions' => $additions,
                            'discounts' => $discounts,
                            'total' => $total,
                        ]);
                    }
                }
                /*--------------------------------*/

                $loans = $worker->loans()->sum('amount');
                if ($request->loans[$worker->id] > $loans || $request->loans[$worker->id] < 0) {
                    throw new \ErrorException('Max Loan Of ' . $worker->name . ' is ' . $loans);
                }
                $loans_request = $request->loans[$worker->id];

                $net = $timesheet->sum('total') - $loans_request - $worker->job->taxes - $worker->job->insurance;
                $sum_net += $net;
                AccountingWorkerSalaryDetail::create([
                    'worker_id' => $worker->id,
                    'project_id' => $worker->project_id,
                    'accounting_id' => $row->id,
                    'days' => $timesheet->count(),
                    'daily_salary' => $timesheet->sum('daily_salary'),
                    'overtime' => $timesheet->sum('overtime'),
                    'additional_overtime' => $timesheet->sum('additional_overtime'),
                    'additions' => $timesheet->sum('additions'),
                    'deduction_hrs' => $timesheet->sum('deduction_hrs'),
                    'deduction_value' => $timesheet->sum('deduction_value'),
                    'safety' => $timesheet->sum('safety'),
                    'discounts' => $timesheet->sum('discounts'),
                    'total' => $timesheet->sum('total'),
                    'loans' => $loans_request,
                    'taxes' => $worker->job->taxes,
                    'insurance' => $worker->job->insurance,
                    'net' => $net,
                ]);
                $timesheet->update([
                    'accounting_id' => $row->id,
                ]);
                // update employee loans
                $worker_loans = $worker->loans()->whereNull('accounting_id')->get();

                foreach ($worker_loans as $worker_loan) {
                    if ($worker_loan->amount < $loans_request) {
                        $loans_request -= $worker_loan->amount;
                        $worker_loan->update([
                            'accounting_id' => $row->id,
                        ]);

                    } elseif ($worker_loan->amount == $loans_request) {
                        $worker_loan->update([
                            'accounting_id' => $row->id,
                        ]);
                        break;
                    } elseif ($worker_loan->amount > $loans_request && $loans_request > 0) {
                        Accounting::create([

                            'date' => $worker_loan->date,
                            'amount' => $loans_request,
                            'type' => 'workerLoan',
                            'safe_id' => $worker_loan->safe_id,
                            'worker_id' => $worker->id,
                            'payment_status' => "confirmed",
                            'manager_status' => "accept",
                            'accounting_id' => $row->id,

                        ]);

                        $worker_loan->update([
                            'amount' => $worker_loan->amount - $loans_request
                        ]);
                        break;
                    }
                }
                /*--------------------------------*/

            }
            $row->amount = $sum_net;
            $row->save();


            DB::commit();

            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('New Worker Salary request id :subject.id  ');

            $notifiers = User::permission('managerNotification')->get();

            $title = 'worker salary';
            $message = 'New Worker Salary # ' . $row->id . ' Added by (' . auth()->user()->name . ') and needs your Approval ';
            $link = url('admin/worker-salary/' . $row->id);
            PusherNotification::sendAll($notifiers, $title, $message, $link);

            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/worker-salary');


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
        $row = Accounting::where('id', $id)->where('type', 'workerSalary')->first();
        return view('admin.worker_salary.show', compact('row'));
    }

    public function detailsPrint($id)
    {


        $row = Accounting::find($id);
        return view('admin.worker_salary.details_print', compact('row'));
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
                        ->log('The Worker Salary request id :subject.id Manager Accepted ');
                    $notifiers = User::permission('accountantNotification')->get();

                    $title = 'Worker salary';
                    $message = 'Worker Salary # ' . $row->id . ' accepted by manager (' . auth()->user()->name . ')';
                    $link = url('admin/worker-salary/' . $row->id);
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
                ->log('The Worker Salary request id :subject.id Manager Accepted ');

            $notifiers = User::permission('safeNotification')->get();

            $title = 'worker salary';
            $message = 'New Worker Salary # ' . $row->id . ' Added by (' . auth()->user()->name . ') and needs your Approval ';
            $link = url('admin/accounting/' . $row->id);
            PusherNotification::sendAll($notifiers, $title, $message, $link);
        } elseif ($request->manager_status == "decline") {
            $row->manager_status = $request->manager_status;
            $row->save();
            WorkerTimeSheet::where('accounting_id', $row->id)->update(['accounting_id' => null]);
            Accounting::where('accounting_id', $row->id)->where('type', 'workerLoan')->where('payment_status', 'confirmed')->update(['accounting_id' => null]);

            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('The  Worker Salary request id :subject.id Manager Declined ');

            $notifiers = User::permission('accountantNotification')->get();

            $title = 'Worker salary';
            $message = 'Worker Salary # ' . $row->id . ' Declined by Manager (' . auth()->user()->name . ')';
            $link = url('admin/worker-salary/' . $row->id);
            PusherNotification::sendAll($notifiers, $title, $message, $link);

            toastr()->success(trans('main.decline_done_successfully'));
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
                if ($row->amount > $safe->balance) {
                    DB::rollBack();
                    return back()->withErrors(trans('main.amount_bigger_than_safe_balance'))->withInput();
                }
                $row->payment_status = $request->payment_status;
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
                DB::commit();
                toastr()->success(trans('main.confirm_done_successfully'));


                activity()
                    ->performedOn($row)
                    ->causedBy(auth()->user())
                    ->log('The Worker Salary request id :subject.id Safe Accepted ');
                $notifiers = User::permission(['accountantNotification', 'managerNotification'])->get();
                $title = 'Worker salary';
                $message = 'Worker Salary # ' . $row->id . ' accepted by  Safe Employee (' . auth()->user()->name . ')';
                $link = url('admin/worker-salary/' . $row->id);
                PusherNotification::sendAll($notifiers, $title, $message, $link);


            } elseif ($request->payment_status == "cancel") {
                $row->payment_status = $request->payment_status;
                $row->save();
                WorkerTimeSheet::where('accounting_id', $row->id)->update(['accounting_id' => null]);
                Accounting::where('accounting_id', $row->id)->where('type', 'workerLoan')->where('payment_status', 'confirmed')->update(['accounting_id' => null]);
                DB::commit();
                toastr()->success(trans('main.decline_done_successfully'));

                activity()
                    ->performedOn($row)
                    ->causedBy(auth()->user())
                    ->log('The Worker Salary request id :subject.id Safe Declined ');

                $notifiers = User::permission('managerNotification')->get();

                $title = 'Worker salary';
                $message = 'Worker Salary # ' . $row->id . ' Declined by Safe Employee (' . auth()->user()->name . ')';
                $link = url('admin/worker-salary/' . $row->id);
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
