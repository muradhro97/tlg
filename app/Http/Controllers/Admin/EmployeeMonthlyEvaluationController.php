<?php

namespace App\Http\Controllers\Admin;

use App\Employee;
use App\EmployeeMonthlyEvaluation;


use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class EmployeeMonthlyEvaluationController extends Controller
{
    //

    public function __construct()
    {

        $this->middleware('permission:allEmpMonthlyEvaluation', ['only' => ['index']]);
        $this->middleware('permission:addEmpMonthlyEvaluation', ['only' => ['create', 'store']]);
        $this->middleware('permission:editEmpMonthlyEvaluation', ['only' => ['edit', 'update']]);
        $this->middleware('permission:deleteEmpMonthlyEvaluation', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        //
        $rows = EmployeeMonthlyEvaluation::latest();
        if ($request->filled('name')) {
            $rows->where('name', 'like', "%$request->name%");


        }

        $rows = $rows->paginate(20);

        return view('admin.employee_monthly_evaluation.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(EmployeeMonthlyEvaluation $model)
    {
//        return "asa";
        return view('admin.employee_monthly_evaluation.create', compact('model'));
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

        $rules = [
//            'user_name' => 'required|unique:users,user_name',
            'image' => 'required|image|mimes:jpg,jpeg,bmp,png',
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date|date_format:F Y',
            'monthly_evaluation_percentage' => 'required|numeric|min:1|max:99.99',


        ];
        $validator = validator()->make($request->all(), $rules);

        $validator->after(function ($validator) use ($request) {
            $check = EmployeeMonthlyEvaluation::where('employee_id', $request->employee_id)
                ->whereMonth('date', Carbon::parse($request->date))
                ->whereYear('date', Carbon::parse($request->date))
                ->first();
//dd($check);

            if ($check) {

                $validator->errors()->add('check', trans('main.add_before_select_another_date_or_employee'));
//                    $validator->errors()->add('employee_id', trans('main.please_add_employee'));
            }

        });
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();


        }
        $employee = Employee::find($request->employee_id);
        $current_salary = $employee->current_salary ?? 1;
        $amount = $current_salary * $request->monthly_evaluation_percentage / 100;
        $request->merge(['current_salary' => $current_salary]);
        $request->merge(['amount' => $amount]);
        $request->merge(['date' => Carbon::parse($request->date)]);
        $row = EmployeeMonthlyEvaluation::create($request->all());

        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The employee monthly evaluation :subject.id created');
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/employee-monthly-evaluation');
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
        $model = EmployeeMonthlyEvaluation::findOrFail($id);

        if ($model->accounting_id) {
            return redirect('admin/employee-monthly-evaluation');
        }
        return view('admin.employee_monthly_evaluation.edit', compact('model'));
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

        $rules = [
//            'image' => 'image|mimes:jpg,jpeg,bmp,png',
//            'employee_id' => 'required|exists:employees,id',
//            'date' => 'required|date|date_format:F Y',
            'monthly_evaluation_percentage' => 'required|numeric|min:1|max:99.99',


        ];
        if ($request->image != null and $request->has('image')) {

            $rules['image'] = 'image|mimes:jpg,jpeg,bmp,png';
        }

        $validator = validator()->make($request->all(), $rules);


        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();


        }

        $row = EmployeeMonthlyEvaluation::findOrFail($id);
        if ($row->accounting_id) {
            return redirect('admin/employee-monthly-evaluation');
        }
        $current_salary = $row->current_salary ;
        $amount = $current_salary * $request->monthly_evaluation_percentage / 100;
        $row->monthly_evaluation_percentage = $request->monthly_evaluation_percentage;
        $row->amount = $amount;
        $row->image = $request->image;
        $row->save();
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The employee monthly evaluation :subject.id updated');

//        $client->roles()->sync($request->role);
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/employee-monthly-evaluation');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $row = EmployeeMonthlyEvaluation::findOrFail($id);

        if ($row->accounting_id) {
            return redirect('admin/employee-monthly-evaluation');
        }

        $row->delete();
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The employee monthly evaluation :subject.id deleted');
        toastr()->success(trans('main.delete_done_successfully'));
        return back();

    }


}
