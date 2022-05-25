<?php

namespace App\Http\Controllers\Admin;

use App\Accounting;
use App\Http\Controllers\Controller;

use App\Safe;
use App\SafeTransaction;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AccountingController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('permission:accountingRequest', ['only' => ['accountingRequest']]);



    }

    public function accountingRequest(Request $request)
    {

        $rows = Accounting::latest()->where('safe_id', 0)
            ->where('payment_status', 'waiting')
            ->where('manager_status', 'accept');

        if ($request->filled('type')) {
            $rows->where('type', $request->type);
        }
        $rows = $rows->paginate(20);


        return view('admin.accounting.accounting_request', compact('rows'));
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
        if ($row->type) {
            switch ($row->type) {
                case "cashin":
                    return view('admin.accounting_cash_in.show', compact('row'));
                    break;
                case "invoice":
                    return view('admin.invoice.show', compact('row'));
                    break;
                case "expense":
                    return view('admin.invoice.show', compact('row'));
                    break;
                case "workerLoan":
                    return view('admin.worker_loan.show', compact('row'));
                    break;
                case "employeeLoan":
                    return view('admin.employee_loan.show', compact('row'));
                    break;

                case "workerSalary":
                    return view('admin.worker_salary.show', compact('row'));
                    break;
                case "employeeSalary":
                    return view('admin.employee_salary.show', compact('row'));
                    break;
                default:
                    return view('admin.accounting.show', compact('row'));
            }
        }

        return view('admin.accounting.show', compact('row'));
    }

    public function changeStatus(Request $request)
    {
//        return "asa";
        DB::beginTransaction();
        try {
            $row = Accounting::find($request->id);
            $row->payment_status = $request->payment_status;
            $row->save();
            if ($request->payment_status == "confirmed") {
                $safe = Safe::find($row->safe_id);

                SafeTransaction::create([

                    'accounting_id' => $row->id,
                    'amount' => $row->amount,
                    'module' => 'accounting',
                    'balance' => $safe->balance,
                    'new_balance' => $safe->balance + $row->amount,
                    'safe_id' => $row->safe_id,


                ]);
                $safe->balance = $safe->balance + $row->amount;
                $safe->save();
                toastr()->success(trans('main.confirm_done_successfully'));
            } elseif ($request->payment_status == "cancel") {
                toastr()->success(trans('main.decline_done_successfully'));
            }

            DB::commit();
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
