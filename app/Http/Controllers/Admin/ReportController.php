<?php

namespace App\Http\Controllers\admin;

use App\Item;
use App\Extract;
use App\Employee;
use App\Accounting;
use App\Organization;
use App\AccountingDetail;
use App\Project;
use App\SafeTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use App\AccountingWorkerSalaryDetail;
use App\AccountingEmployeeSalaryDetail;
use Illuminate\Pagination\LengthAwarePaginator;

class ReportController extends Controller
{
    public function directCost(Request $request){
        /* total worker salaries*/
        $user=Auth::user();
        $product_ids=$user->projects()->select('project_id');

        $rows = AccountingWorkerSalaryDetail::whereHas('accounting',function ($query){
            return $query->where('payment_status','confirmed');
        })->whereHas('worker',function ($query)use ($product_ids){
            $query->whereIn('project_id' , $product_ids);
        })->latest();
        // $rows->whereIn('project_id',$product_ids);
        if ($request->filled('from')) {
            $rows->whereHas('accounting', function ($q) use ($request){
                $q->where('start' ,'>=' , $request->from);
            });
        }
        if ($request->filled('to')) {
            $rows->whereHas('accounting', function ($q) use ($request){
                $q->where('end' ,'<=' , $request->to);
            });
        }
        if ($request->filled('project_id')) {
            $rows->where('project_id' , $request->project_id);
        }
        $salaries = $rows->sum('total');

        /*total invoices*/
        $rows = Accounting::latest()->where('type', 'invoice')->where('payment_status','confirmed');
        if ($request->filled('from')) {
            $rows->where('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $rows->where('created_at', '<=', $request->to);
        }
        if ($request->filled('project_id'))
        {
            $rows->where('project_id', $request->project_id);
        }
        $invoices = $rows->sum('amount');

        /*total extracts*/
        $rows = Extract::whereHas('organization',function ($query){
            return $query->where('type','subContractor');
        })->latest();
        if ($request->filled('project_id')) {
            $rows->where('project_id', $request->project_id);
        }
        if ($request->filled('organization_id')) {
            $rows->where('organization_id', $request->organization_id);
        }
        if ($request->filled('type_id')) {
            $rows->where('type_id', $request->type_id);
        }
        if ($request->filled('sub_contract_id')) {
            $rows->where('sub_contract_id', $request->sub_contract_id);
        }
        if ($request->filled('from')) {
            $rows->where('period_from', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $rows->where('period_to', '<=', $request->to);
        }
        $extracts  = $rows->sum('total');
        $total = $salaries + $invoices + $extracts;
        return view('admin.report.direct_cost.index' , compact('salaries','invoices','extracts','total'));
    }

    public function directWorkerSalaries(Request $request){
        $user=Auth::user();
        $product_ids=$user->projects()->select('project_id');


        $rows = AccountingWorkerSalaryDetail::whereHas('accounting',function ($query){
            return $query->where('payment_status','confirmed');
        })->whereHas('worker',function ($query)use ($product_ids){
            $query->whereIn('project_id' , $product_ids);
        })->latest();
        // $rows->whereIn('project_id',$product_ids);

        if ($request->filled('from')) {
            $rows->whereHas('accounting', function ($q) use ($request){
                $q->where('start' ,'>=' , $request->from);
            });
        }
        if ($request->filled('to')) {
            $rows->whereHas('accounting', function ($q) use ($request){
                $q->where('end' ,'<=' , $request->to);
            });
        }

        if ($request->filled('project_id')) {
            $rows->where('project_id' , $request->project_id);
        }

        $rows = $rows->get();
        return view('admin.report.direct_cost.worker_salaries' , compact('rows'));
    }

    public function directInvoices(Request $request){

        $user=Auth::user();
        $product_ids=$user->projects()->select('project_id');

        $rows = Accounting::latest()->where('type', 'invoice')->where('payment_status','confirmed');
        $rows->whereIn('project_id',$product_ids);
        if ($request->filled('from')) {
            $rows->where('created_at', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $rows->where('created_at', '<=', $request->to);
        }

        if ($request->filled('project_id'))
        {
            $rows->where('project_id', $request->project_id);
        }

        $total = $rows->sum('amount');
        $rows = $rows->paginate(20);
        return view('admin.report.direct_cost.invoices' , compact('rows','total'));
    }

    public function directExtracts(Request $request){

        $user=Auth::user();
        $product_ids=$user->projects()->select('project_id');

        $rows = Extract::whereHas('organization',function ($query){
            return $query->where('type','subContractor');
        })->latest();

        $rows->whereIn('project_id',$product_ids);
        if ($request->filled('project_id')) {
            $rows->where('project_id', $request->project_id);
        }
        if ($request->filled('organization_id')) {
            $rows->where('organization_id', $request->organization_id);
        }
        if ($request->filled('type_id')) {
            $rows->where('type_id', $request->type_id);
        }
        if ($request->filled('sub_contract_id')) {
            $rows->where('sub_contract_id', $request->sub_contract_id);
        }
        if ($request->filled('from')) {
            $rows->where('period_from', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $rows->where('period_to', '<=', $request->to);
        }

        $total = $rows->sum('total');
        $rows = $rows->paginate(20);

        return view('admin.report.direct_cost.extracts' , compact('rows','total'));

    }

    public function indirectCost(Request $request){


        $user=Auth::user();
        $product_ids=$user->projects()->select('project_id');
        // $rows->whereIn('project_id',$product_ids);
        $rows = AccountingEmployeeSalaryDetail::whereHas('accounting',function ($query){
            return $query->where('payment_status','confirmed');
        })->whereHas('accounting',function ($query)use ($product_ids){
            $query->whereIn('project_id' , $product_ids);
        })->latest();

        if ($request->filled('from')) {
            $rows->where('created_at', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $rows->where('created_at', '<=', $request->to);
        }

        if ($request->filled('project_id')) {
            $rows->where('project_id' , $request->project_id);
        }

        $rows = $rows->get();
        $salaries = $rows->sum('net') + $rows->sum('loans');

        $rows = AccountingDetail::whereHas('accounting',function ($query) use ($request){
            $query->where('type', 'expense')->where('payment_status','confirmed');
            if ($request->filled('from')) {
                $query->where('date', '>=', $request->from);
            }

            if ($request->filled('to')) {
                $query->where('date', '<=', $request->to);
            }
            return $query;
        });

        if ($request->filled('project_id')) {
            $rows->whereHas('accounting',function ($query) use ($request){
                return $query->where('project_id', $request->project_id);
            });
        }

        $expenses =$rows->get()->sum(function ($q){
            return $q->quantity * $q->price;
        });

        $total = $salaries + $expenses;
        return view('admin.report.indirect_cost.index' , compact('salaries','expenses','total'));
    }

    public function indirectEmployeeSalaries(Request $request){
        $user=Auth::user();
        $product_ids=$user->projects()->select('project_id');
        $rows = AccountingEmployeeSalaryDetail::whereHas('accounting',function ($query){
            return $query->where('payment_status','confirmed');
        })->whereHas('employee',function ($query)use ($product_ids){
            $query->whereIn('project_id' , $product_ids);
        })->latest();


        // $rows->whereIn('project_id',$product_ids);

        if ($request->filled('from')) {
            $rows->where('created_at', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $rows->where('created_at', '<=', $request->to);
        }

        if ($request->filled('project_id')) {
            $rows->where('project_id' , $request->project_id);
        }

        $rows = $rows->get();
        return view('admin.report.indirect_cost.employee_salaries' , compact('rows'));
    }

    public function indirectExpenses(Request $request){
        $user=Auth::user();
        $product_ids=$user->projects()->select('project_id');

        $rows = AccountingDetail::whereHas('accounting',function ($query) use ($request){
            $query->where('type', 'expense')->where('payment_status','confirmed');
            if ($request->filled('from')) {
                $query->where('date', '>=', $request->from);
            }

            if ($request->filled('to')) {
                $query->where('date', '<=', $request->to);
            }
            return $query;
        })->whereHas('accounting',function ($query)use ($product_ids){
            $query->whereIn('project_id' , $product_ids);
        });


        // $rows->whereIn('project_id',$product_ids);


        if ($request->filled('project_id')) {
            $rows->whereHas('accounting',function ($query) use ($request){
                return $query->where('project_id', $request->project_id);
            });
        }

        $total = $rows->get()->sum(function ($q){
            return $q->quantity * $q->price;
        });

        $grouped_rows  = clone $rows;

        $rows = $rows->get();

        $grouped_rows = $grouped_rows->groupby('item_id')->select('item_id', DB::raw('sum(quantity * price) as total'))->get();

        $total_grouped = $grouped_rows->sum('total');

        return view('admin.report.indirect_cost.expenses' , compact('rows','grouped_rows','total_grouped','total'));
    }

    public function stockItems(Request $request){
        //
        $rows = Item::latest();
        if ($request->filled('name')) {
            $rows->where('name', 'like', "%$request->name%");
        }

        $rows = $rows->get();

        return view('admin.report.stock_items.index', compact('rows'));
    }

    public function stockItemDetails(Item $item)
    {
        $item_quantities = $item->all_item_quantities()->where('quantity', '>',0)->paginate(20);
        $item_stock_details = $item->stock_order_details()->whereHas('stock_order' ,function ($q){
            return $q->where('type','out')->where('status','approve');
        })->paginate(20);

        return view('admin.report.stock_items.details', compact('item_quantities','item_stock_details'));
    }

    public function custody(Request $request){
        $employees = Employee::query();

        if ($request->filled('name'))
        {
            $employees->where('name','like','%'.$request->name.'%');
        }

        $employees= $employees->get()->map(function (Employee $employee){
            $invoice_amount = $employee->custodyInvoices()->sum('amount');
            $custody_amount = $employee->custody()->sum('amount');
            return [
                'id' => $employee->id,
                'name' => $employee->name,
                'creditor'  => $invoice_amount > $custody_amount ? $invoice_amount-$custody_amount : '---',
                'debtor'    =>  $custody_amount > $invoice_amount ? $custody_amount-$invoice_amount : '---'
            ];
        });
        $employees =new LengthAwarePaginator($employees->forPage($request->page,10), count($employees),10,$request->page,[
            'path'  => Paginator::resolveCurrentPath()
        ]);

        return view('admin.report.custody.index', compact('employees'));

    }

    public function custodyDetails(Employee $employee){
        $invoices = $employee->custodyInvoices;
        $custody = $employee->custody;

        $mergedRows = $invoices->merge($custody);

        $mergedRows = $mergedRows->sortBy('date');
        return view('admin.report.custody.details', compact('mergedRows','employee'));

    }

    public function cashIn(Request $request){
        $user=Auth::user();
        $product_ids=$user->projects()->select('project_id');

        $funding_rows = Accounting::cashin()->whereHas('organization',function ($query){
            return $query->where('type','mainContractor');
        });
        $funding_rows->whereIn('project_id', $product_ids);
        $cash_in_rows = Accounting::cashin()->whereHas('organization',function ($query){
            return $query->where('type','subContractor');
        });
        $cash_in_rows->whereIn('project_id', $product_ids);
        $extract_rows = Extract::whereHas('organization',function ($query){
            return $query->where('type','mainContractor');
        });
        $extract_rows->whereIn('project_id', $product_ids);
        if ($request->filled('amount_from')) {
            $funding_rows->where('amount', '>=', $request->amount_from);
            $cash_in_rows->where('amount', '>=', $request->amount_from);
            $extract_rows->where('total', '>=', $request->amount_from);
        }

        if ($request->filled('amount_to')) {
            $funding_rows->where('amount', '<=', $request->amount_to);
            $cash_in_rows->where('amount', '<=', $request->amount_to);
            $extract_rows->where('total', '<=', $request->amount_to);
        }

        if ($request->filled('from')) {
            $funding_rows->where('date', '>=', $request->from);
            $cash_in_rows->where('date', '>=', $request->from);
            $extract_rows->where('date', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $funding_rows->where('date', '<=', $request->to);
            $cash_in_rows->where('date', '<=', $request->to);
            $extract_rows->where('date', '<=', $request->to);
        }

        if ($request->filled('project_id')) {
            $funding_rows->where('project_id' , $request->project_id);
            $cash_in_rows->where('project_id' , $request->project_id);
            $extract_rows->where('project_id' , $request->project_id);
        }

        if ($request->filled('organization_id')) {
            $funding_rows->where('organization_id' , $request->organization_id);
            $cash_in_rows->where('organization_id' , $request->organization_id);
            $extract_rows->where('organization_id' , $request->organization_id);
        }

        $total_funding = $funding_rows->sum('amount');
        $total_cash_in = $cash_in_rows->sum('amount');
        $total_extracts = $extract_rows->sum('total');

//        $funding_rows = $funding_rows->paginate(10,['*'], 'funding');
//        $cash_in_rows = $cash_in_rows->paginate(10,['*'], 'cash_in');
//        $extract_rows = $extract_rows->paginate(10,['*'], 'extracts');

        $funding_rows = $funding_rows->get();
        $cash_in_rows = $cash_in_rows->get();
        $extract_rows = $extract_rows->get();

        return view('admin.report.cash_in.index', compact('funding_rows','cash_in_rows','extract_rows','total_cash_in','total_funding','total_extracts'));
    }

    public function workerLoans(Request $request){
        $rows = Accounting::orderBy('date','desc')->where('type', 'workerLoan');

        if ($request->filled('worker_id')) {
            $rows->where('worker_id', $request->worker_id);
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

        $rows = $rows->get();

        return view('admin.report.loans.worker_loans', compact('rows'));
    }

    public function employeeLoans(Request $request){
        $rows = Accounting::orderBy('date','desc')->where('type','employeeLoan');
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

        $rows = $rows->get();

        return view('admin.report.loans.employee_loans', compact('rows'));
    }

    public function organizations(Request $request){
        $rows = Organization::all();
        return view('admin.report.organizations.index', compact('rows'));
    }

    public function organizations_details(Organization $organization){
        $extracts = $organization->extracts;
        if ($organization->type == 'subContractor')
        {
            $rows = $organization->confirmedCashOut->merge($organization->confirmendActualCashOut);
        }
        else
        {
            $rows = $organization->confirmendActualCashIn;
        }
        return view('admin.report.organizations.details', compact('extracts','rows','organization'));
    }

    public function human_resources(Request $request){
        $projects = Project::query();
        if ($request->filled('project_id'))
        {
            $projects->where('id',$request->project_id);
        }

        $projects->with(['employeeTimeSheets' => function ($query)use ($request){
            if ($request->filled('organization_id'))
            {
                $query->whereHas('employee',function ($query) use ($request){
                    $query->where('organization_id',$request->organization_id);
                });
            }
//            if ($request->filled('job_id'))
//            {
//                $query->whereHas('employee',function ($query) use ($request){
//                    $query->where('job_id',$request->job_id);
//                });
//            }
            if ($request->filled('from')) {
                $query->where('date', '>=', $request->from);
            }
            if ($request->filled('to')) {
                $query->where('date', '<=', $request->to);
            }
            if ($request->filled('attendance'))
            {
                $query->where('attendance',$request->attendance);
            }

            return $query;
        }]);


        $projects->with(['workerTimeSheets' => function ($query)use ($request){
            if ($request->filled('organization_id'))
            {
                $query->whereHas('worker',function ($query) use ($request){
                    $query->where('organization_id',$request->organization_id);
                });
            }
//            if ($request->filled('job_id'))
//            {
//                $query->whereHas('worker',function ($query) use ($request){
//                    $query->where('job_id',$request->job_id);
//                });
//            }
            if ($request->filled('from')) {
                $query->where('date', '>=', $request->from);
            }
            if ($request->filled('to')) {
                $query->where('date', '<=', $request->to);
            }
            if ($request->filled('attendance'))
            {
                $query->where('attendance',$request->attendance);
            }
            return $query;
        }]);

        $rows = $projects->get()->map(function ($project){
            $project->employees_count = $project->employeeTimeSheets->count();
            $project->employees_counts =$project->employeeTimeSheets()->with('employee')
                ->groupBy('job_id')
                ->orderBy(DB::raw('COUNT(employees.id)','desc'))
                ->get(array(DB::raw('COUNT(employees.id) as employee_count'),'job_id'));

            $project->worker_count = $project->workerTimeSheets->count();
            $project->worker_counts =$project->workerTimeSheets()->with('worker')
                ->groupBy('job_id')
                ->orderBy(DB::raw('COUNT(workers.id)','desc'))
                ->get(array(DB::raw('COUNT(workers.id) as worker_count'),'job_id'));
            return $project;
        });

        return view('admin.report.human_resources.index', compact('rows'));
    }

    public function safe(Request $request){
        $from = $request->from;
        $to = $request->to;

        /* Cash In */
        $safe_transactions_cash_in = SafeTransaction::query();
        $safe_transactions_cash_in->where('safe_id',0);
        $safe_transactions_cash_in->where(function ($query){
            return $query->whereHas('payment',function ($query){
                return $query->whereIn('type',['cashin']);
            });
        });
        $safe_transactions_cash_in->when($from,function ($query)use ($from){
            return $query->whereDate('safe_transactions.created_at', '>=', $from);
        });

        $safe_transactions_cash_in->when($to,function ($query)use ($to){
            return $query->whereDate('safe_transactions.created_at', '<=', $to);
        });
        /* ------------------------------End Cash In */

        /* Cash out */
        $safe_transactions = SafeTransaction::query();
        $safe_transactions->where('safe_id',0);
        $safe_transactions->where(function ($query){
            return $query->whereHas('accounting',function ($query){
                return $query->whereNotIn('type',['cashin','cashout']);
            })->orWhereHas('payment',function ($query){
                return $query->whereIn('type',['custody','cashout']);
            });
        });
        $safe_transactions->when($from,function ($query)use ($from){
            return $query->whereDate('safe_transactions.created_at', '>=', $from);
        });
        $safe_transactions->when($to,function ($query)use ($to){
            return $query->whereDate('safe_transactions.created_at', '<=', $to);
        });
        /* ------------------------------End Cash Out */


        $safe_transactions = $safe_transactions->get();
        $safe_transactions_cash_in = $safe_transactions_cash_in->get();

        $all  = $safe_transactions->merge($safe_transactions_cash_in);
        $old_transaction = $all->sortBy('created_at')->first();
        $new_transaction = $all->sortByDesc('created_at')->first();

        return view('admin.report.safe.index', compact('safe_transactions','safe_transactions_cash_in','old_transaction','new_transaction'));

    }

}












