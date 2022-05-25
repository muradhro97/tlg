<?php

namespace App\Http\Controllers\Admin;

use App\AccountingImage;
use App\Employee;
use App\EmployeeTimeSheet;
use App\Exports\EmployeeTimeSheetHistoryExport;
use App\Extract;
use App\ExtractDetail;
use App\Http\Controllers\Controller;
use App\Accounting;
use App\Safe;
use App\SafeTransaction;
use App\Worker;
use App\WorkerTimeSheet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeTimeSheetController extends Controller
{
    //


    public function __construct()
    {
        $this->middleware('permission:addEmpTime', ['only' => ['index', 'store']]);
        $this->middleware('permission:editEmpTime', ['only' => ['edit', 'update','updateAll']]);
        $this->middleware('permission:deleteEmpTime', ['only' => ['destroy','destroyGET']]);
        $this->middleware('permission:historyEmpTime', ['only' => ['employeeTimeSheetHistory']]);


    }

    public function index(Request $request)
    {
        //
        $model = new EmployeeTimeSheet();
        $projects = auth()->user()->projects->pluck('id')->toArray();
        $rows = Employee::latest()->where('working_status', 'work')->whereIn('project_id', $projects);
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
        if ($request->filled('date')) {
            $date = $request->date;
        } else {
            $date = Carbon::today();
        }
        $rows->whereDoesntHave('employeeTimeSheet', function ($q) use ($date) {
            $q->where('date', $date);

        });


        $rows = $rows->get();

        return view('admin.employee_time_sheet.index', compact('rows', 'model'));
    }

    public function employeeTimeSheetHistory(Request $request)
    {
        //
        $model = new EmployeeTimeSheet();

        $projects = auth()->user()->projects->pluck('id')->toArray();
        $rows = EmployeeTimeSheet::orderBy('date','desc')
            ->whereHas('employee', function ($q) use ($request, $projects) {
                $q->whereIn('project_id', $projects);

            });
        if ($request->filled('project_id')) {
            $rows->whereHas('employee', function ($q) use ($request) {
                $q->where('project_id', $request->project_id);

            });
        }

        if ($request->filled('organization_id')) {
            $rows->whereHas('employee', function ($q) use ($request) {
                $q->where('organization_id', $request->organization_id);

            });
        }

        if ($request->filled('department_id')) {
            $rows->whereHas('employee', function ($q) use ($request) {
                $q->where('department_id', $request->department_id);

            });
        }
//        if ($request->filled('job_id')) {
//            $rows->whereHas('employee', function ($q) use ($request) {
//                $q->where('job_id', $request->job_id);
//
//            });
//        }

        if ($request->filled('employee_id')) {
            $rows->where('employee_id', $request->employee_id);
        }
        if ($request->filled('from')) {
            $rows->where('date', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $rows->where('date', '<=', $request->to);
        }


        $rows = $rows->paginate(20);

        return view('admin.employee_time_sheet.history', compact('rows','model','request'));
    }

    public function exportExcel(Request $request){
        $response = Excel::download(new EmployeeTimeSheetHistoryExport($request), 'employee_time_sheet_history.xlsx');
        ob_end_clean();

        return $response;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Accounting $model)
    {
//        return "asa";
        return view('admin.extract.create_extract', compact('model'));
    }


    public function store(Request $request)
    {


//        return "under constrction";
        //
//        return $items = json_decode($request->items);
//        return $request->all();
        $rules = [

            'date' => 'required|date|date_format:Y-m-d',
            'attendance' => 'required|in:yes,no,official_vacation_yes,official_vacation_no,normal_vacation,casual_vacation',
//            'overtime' => 'numeric|min:0',
//            'deduction_hrs' => 'numeric|min:0',
//            'safety' => 'numeric|min:0',
        ];


        $validator = validator()->make($request->all(), $rules);

        $validator->after(function ($validator) use ($request) {
            if ($request->ids) {

                if (count($request->ids) < 1) {

                    $validator->errors()->add('ids', trans('main.please_add_employee'));
                }
            } else {
                $validator->errors()->add('ids', trans('main.please_add_employee'));

            }
            if ($request->attendance == "yes" || $request->attendance == "official_vacation_yes") {
                if (!(($request->from1 and $request->to1) or ($request->from2 and $request->to2))) {
                    $validator->errors()->add('ids', trans('main.please_add_period'));
                }
            }

        });
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        DB::beginTransaction();
        try {
            if ($request->attendance == "yes") {
//                dd(1);
                $hrs1 = (new Carbon($request->from1))->diff(new Carbon($request->to1))->format('%H:%I');
                $hrs2 = (new Carbon($request->from2))->diff(new Carbon($request->to2))->format('%H:%I');
                $total_daily_minutes = (new Carbon($request->from1))->diffInMinutes(new Carbon($request->to1)) + (new Carbon($request->from2))->diffInMinutes(new Carbon($request->to2));
                $overtime_minutes = $total_daily_minutes - (8 * 60);
                if ($overtime_minutes < 0) {
                    $total_regular_minutes = $total_daily_minutes;
                    $overtime_minutes = 0;
                } else {
                    $total_regular_minutes = 8 * 60;
                }

            }
            elseif ($request->attendance == "official_vacation_yes") {
//                dd(1);
                $hrs1 = (new Carbon($request->from1))->diff(new Carbon($request->to1))->format('%H:%I');
                $hrs2 = (new Carbon($request->from2))->diff(new Carbon($request->to2))->format('%H:%I');
                $total_daily_minutes = (new Carbon($request->from1))->diffInMinutes(new Carbon($request->to1)) + (new Carbon($request->from2))->diffInMinutes(new Carbon($request->to2));
                $overtime_minutes = $total_daily_minutes - (8 * 60);

                if ($overtime_minutes < 0) {
                    $total_regular_minutes = $total_daily_minutes;
                    $overtime_minutes = 0;
                } else {
                    $total_regular_minutes = 8 * 60;
                }
                // add 8 hours of vacation to total_daily_minutes
                $total_daily_minutes += 8 * 60;
            }
            elseif ($request->attendance == "official_vacation_no") {
//                dd(1);
                $hrs1 = null;
                $hrs2 = null;
                $overtime_minutes = null;


                // add 8 hours of vacation to total_daily_minutes
                $total_daily_minutes = 8 * 60;
                $total_regular_minutes = 8 * 60;

            }
            elseif ($request->attendance == "normal_vacation") {
//                dd(1);
                $hrs1 = null;
                $hrs2 = null;
                $overtime_minutes = null;


                // add 8 hours of vacation to total_daily_minutes
                $total_daily_minutes = 8 * 60;
                $total_regular_minutes = 8 * 60;

            }
            elseif ($request->attendance == "casual_vacation") {
//                dd(1);
                $hrs1 = null;
                $hrs2 = null;
                $overtime_minutes = null;


                // add 8 hours of vacation to total_daily_minutes
                $total_daily_minutes = 8 * 60;
                $total_regular_minutes = 8 * 60;

            }
            else {
//                dd(2);
                $request->reward = 0;
                $hrs1 = null;
                $hrs2 = null;
                $total_daily_minutes = null;
                $overtime_minutes = null;
                $total_regular_minutes = null;
            }
//dd($total_daily_minutes);
//            $total_daily_hrs = Carbon::parse("00:00:00")->addMinutes($total_daily_minutes);
//            dd($aa->format('H:i:s'));
            foreach ($request->ids as $id) {

                $employee = Employee::find($id);
                if (!$employee) {
                    DB::rollBack();
                    return back()->withErrors(trans('main.server_error'))->withInput();
                }

                $hourly_salary = $employee->hourly_salary;
                if (!$hourly_salary) {
                    DB::rollBack();
                    return back()->withErrors(trans('main.please_enter_employee_hourly_salary_first'))->withInput();
                }

                if ($request->attendance == "normal_vacation") {
                    if ($employee->normal_vacation_no >0)
                    {
                        if ($employee->normal_vacation_no < 1)
                        {
                            $total_daily_minutes = $total_daily_minutes * $employee->normal_vacation_no;
                            $total_regular_minutes = $total_regular_minutes * $employee->normal_vacation_no;

                            // update employee normal_vacation_no
                            $employee->update([
                                'normal_vacation_no'    => 0
                            ]);
                        }
                        else
                        {
                            // update employee normal_vacation_no
                            $employee->update([
                                'normal_vacation_no'    => $employee->normal_vacation_no - 1
                            ]);
                        }
                    }
                    else
                    {
                        DB::rollBack();
                        return back()->withErrors(trans('main.an_employee_is_not_have_enough_vacation_balance'))->withInput();
                    }

                }
                elseif ($request->attendance == "casual_vacation") {
                    if ($employee->casual_vacation_no >0)
                    {
                        if ($employee->casual_vacation_no < 1)
                        {
                            $total_daily_minutes = $total_daily_minutes * $employee->casual_vacation_no;
                            $total_regular_minutes = $total_regular_minutes * $employee->casual_vacation_no;

                            // update employee casual_vacation_no
                            $employee->update([
                                'casual_vacation_no'    => 0
                            ]);
                        }
                        else
                        {
                            // update employee casual_vacation_no
                            $employee->update([
                                'casual_vacation_no'    => $employee->casual_vacation_no - 1
                            ]);
                        }
                    }
                    else
                    {
                        DB::rollBack();
                        return back()->withErrors(trans('main.an_employee_is_not_have_enough_vacation_balance'))->withInput();
                    }
                }

                $total_regular = ($total_regular_minutes / 60) * $hourly_salary;
                $overtime = ($overtime_minutes / 60) * $hourly_salary;
                $total_daily = ($total_daily_minutes / 60) * $hourly_salary;

                $row = EmployeeTimeSheet::create([
                    'date' => $request->date,
                    'employee_id' => $id,
                    'attendance' => $request->attendance,
                    'from1' => $request->from1,
                    'to1' => $request->to1,
                    'from2' => $request->from2,
                    'to2' => $request->to2,
                    'hrs1' => $hrs1,
                    'hrs2' => $hrs2,

                    'total_regular_minutes' => $total_regular_minutes,
                    'overtime_minutes' => $overtime_minutes,
                    'total_daily_minutes' => $total_daily_minutes,
                    'hourly_salary' => $employee->hourly_salary,
                    'total_regular' => $total_regular,
                    'overtime' => $overtime,
                    'reward' => $request->reward,
                    'total_daily' => $total_daily,
                    'details' => $request->details,

                ]);

            }

            activity()
//                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('employee time sheet added for date ' . $request->date);
            DB::commit();
//            return 1;
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

    public function edit($id)
    {
        //
        $model = EmployeeTimeSheet::findOrFail($id);
        return view('admin.employee_time_sheet.edit', compact('model'));
    }

    public function show($id)
    {
//        return "asa";
        $row = Extract::find($id);
        return view('admin.extract.show', compact('row'));
    }

    public function update(Request $request, $id)
    {
        //


//        return "under constrction";
        //
//        return $items = json_decode($request->items);
//        return $request->all();
        $rules = [

//            'date' => 'required|date|date_format:Y-m-d',


            'attendance' => 'required|in:yes,no,official_vacation_yes,official_vacation_no,normal_vacation,casual_vacation',
//            'overtime' => 'numeric|min:0',
//            'deduction_hrs' => 'numeric|min:0',
//            'safety' => 'numeric|min:0',


        ];

        $validator = validator()->make($request->all(), $rules);

        $validator->after(function ($validator) use ($request) {
            if ($request->attendance == "yes" || $request->attendance == "official_vacation_yes") {
                if (!(($request->from1 and $request->to1) or ($request->from2 and $request->to2))) {
                    $validator->errors()->add('ids', trans('main.please_add_period'));
                }
            }

        });
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();


        }
        DB::beginTransaction();
        try {
            if ($request->attendance == "yes") {
//                dd(1);
                $hrs1 = (new Carbon($request->from1))->diff(new Carbon($request->to1))->format('%H:%I');
                $hrs2 = (new Carbon($request->from2))->diff(new Carbon($request->to2))->format('%H:%I');
                $total_daily_minutes = (new Carbon($request->from1))->diffInMinutes(new Carbon($request->to1)) + (new Carbon($request->from2))->diffInMinutes(new Carbon($request->to2));
                $overtime_minutes = $total_daily_minutes - (8 * 60);
                if ($overtime_minutes < 0) {
                    $total_regular_minutes = $total_daily_minutes;
                    $overtime_minutes = 0;
                } else {
                    $total_regular_minutes = 8 * 60;
                }

            }
            elseif ($request->attendance == "official_vacation_yes") {
//                dd(1);
                $hrs1 = (new Carbon($request->from1))->diff(new Carbon($request->to1))->format('%H:%I');
                $hrs2 = (new Carbon($request->from2))->diff(new Carbon($request->to2))->format('%H:%I');
                $total_daily_minutes = (new Carbon($request->from1))->diffInMinutes(new Carbon($request->to1)) + (new Carbon($request->from2))->diffInMinutes(new Carbon($request->to2));
                $overtime_minutes = $total_daily_minutes - (8 * 60);

                if ($overtime_minutes < 0) {
                    $total_regular_minutes = $total_daily_minutes;
                    $overtime_minutes = 0;
                } else {
                    $total_regular_minutes = 8 * 60;
                }
                // add 8 hours of vacation to total_daily_minutes
                $total_daily_minutes += 8 * 60;
            }
            elseif ($request->attendance == "official_vacation_no") {
//                dd(1);
                $hrs1 = null;
                $hrs2 = null;
                $overtime_minutes = null;


                // add 8 hours of vacation to total_daily_minutes
                $total_daily_minutes = 8 * 60;
                $total_regular_minutes = 8 * 60;

            }
            elseif ($request->attendance == "normal_vacation") {
//                dd(1);
                $hrs1 = null;
                $hrs2 = null;
                $overtime_minutes = null;


                // add 8 hours of vacation to total_daily_minutes
                $total_daily_minutes = 8 * 60;
                $total_regular_minutes = 8 * 60;

            }
            elseif ($request->attendance == "casual_vacation") {
//                dd(1);
                $hrs1 = null;
                $hrs2 = null;
                $overtime_minutes = null;


                // add 8 hours of vacation to total_daily_minutes
                $total_daily_minutes = 8 * 60;
                $total_regular_minutes = 8 * 60;

            }
            else {
//                dd(2);
                $request->reward = 0;
                $hrs1 = null;
                $hrs2 = null;
                $total_daily_minutes = null;
                $overtime_minutes = null;
                $total_regular_minutes = null;
            }
//dd($total_daily_minutes);
//            $total_daily_hrs = Carbon::parse("00:00:00")->addMinutes($total_daily_minutes);
//            dd($aa->format('H:i:s'));   foreach ($request->ids as $id) {
/*------------*/





/*----------*/

            $row = EmployeeTimeSheet::find($id);
            $employee = $row->employee;
            //update employee vacation number if i changed vacation restore old value
            if($row->attendance == 'normal_vacation')
            {
                $vacation = $row->total_regular_minutes / $total_regular_minutes;
                $employee->update([
                    'normal_vacation_no'    => $employee->normal_vacation_no + $vacation
                ]);
            }
            elseif($row->attendance == 'casual_vacation')
            {
                $vacation = $row->total_regular_minutes / $total_regular_minutes;
                $employee->update([
                    'casual_vacation_no'    => $employee->casual_vacation_no + $vacation
                ]);
            }

            //update employee vacation
            if ($request->attendance == "normal_vacation") {
                if ($employee->normal_vacation_no >0)
                {
                    if ($employee->normal_vacation_no < 1)
                    {
                        $total_daily_minutes = $total_daily_minutes * $employee->normal_vacation_no;
                        $total_regular_minutes = $total_regular_minutes * $employee->normal_vacation_no;

                        // update employee normal_vacation_no
                        $employee->update([
                            'normal_vacation_no'    => 0
                        ]);
                    }
                    else
                    {
                        // update employee normal_vacation_no
                        $employee->update([
                            'normal_vacation_no'    => $employee->normal_vacation_no - 1
                        ]);
                    }
                }
                else
                {
                    DB::rollBack();
                    return back()->withErrors(trans('main.an_employee_is_not_have_enough_vacation_balance'))->withInput();
                }

            }
            elseif ($request->attendance == "casual_vacation") {
                if ($employee->casual_vacation_no >0)
                {
                    if ($employee->casual_vacation_no < 1)
                    {
                        $total_daily_minutes = $total_daily_minutes * $employee->casual_vacation_no;
                        $total_regular_minutes = $total_regular_minutes * $employee->casual_vacation_no;

                        // update employee casual_vacation_no
                        $employee->update([
                            'casual_vacation_no'    => 0
                        ]);
                    }
                    else
                    {
                        // update employee casual_vacation_no
                        $employee->update([
                            'casual_vacation_no'    => $employee->casual_vacation_no - 1
                        ]);
                    }
                }
                else
                {
                    DB::rollBack();
                    return back()->withErrors(trans('main.an_employee_is_not_have_enough_vacation_balance'))->withInput();
                }
            }

            $hourly_salary = $row->hourly_salary;
            $total_regular = ($total_regular_minutes / 60) * $hourly_salary;
            $overtime = ($overtime_minutes / 60) * $hourly_salary;
            $total_daily = ($total_daily_minutes / 60) * $hourly_salary;
            $row->update([
//                    'date' => $request->date,
//                    'employee_id' => $id,
                'attendance' => $request->attendance,
                'from1' => $request->from1,
                'to1' => $request->to1,
                'from2' => $request->from2,
                'to2' => $request->to2,
                'hrs1' => $hrs1,
                'hrs2' => $hrs2,

                'total_regular_minutes' => $total_regular_minutes,
                'overtime_minutes' => $overtime_minutes,
                'total_daily_minutes' => $total_daily_minutes,

                'hourly_salary' => $hourly_salary,
                'total_regular' => $total_regular,
                'overtime' => $overtime,
                'reward' => $request->reward,
                'total_daily' => $total_daily,
                'details' => $request->details,
            ]);

            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('worker time sheet  :subject.id updated ');


            DB::commit();
//            return 1;
            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/employee-time-sheet-history');


        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage())->withInput();
//            return back();


        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();


            return back()->withErrors($ex->errorInfo[2])->withInput();

        }
    }

    public function updateAll(Request $request)
    {
        //

//        return "under constrction";
        //
//        return $items = json_decode($request->items);
//        return $request->all();
        $rules = [

//            'date' => 'required|date|date_format:Y-m-d',


            'attendance' => 'required|in:yes,no,official_vacation_yes,official_vacation_no,normal_vacation,casual_vacation',
//            'overtime' => 'numeric|min:0',
//            'deduction_hrs' => 'numeric|min:0',
//            'safety' => 'numeric|min:0',


        ];

        $validator = validator()->make($request->all(), $rules);

        $validator->after(function ($validator) use ($request) {
            if ($request->attendance == "yes" || $request->attendance == "official_vacation_yes") {
                if (!(($request->from1 and $request->to1) or ($request->from2 and $request->to2))) {
                    $validator->errors()->add('ids', trans('main.please_add_period'));
                }
            }

        });
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();


        }
        DB::beginTransaction();
        try {
            if ($request->attendance == "yes") {
//                dd(1);
                $hrs1 = (new Carbon($request->from1))->diff(new Carbon($request->to1))->format('%H:%I');
                $hrs2 = (new Carbon($request->from2))->diff(new Carbon($request->to2))->format('%H:%I');
                $total_daily_minutes = (new Carbon($request->from1))->diffInMinutes(new Carbon($request->to1)) + (new Carbon($request->from2))->diffInMinutes(new Carbon($request->to2));
                $overtime_minutes = $total_daily_minutes - (8 * 60);
                if ($overtime_minutes < 0) {
                    $total_regular_minutes = $total_daily_minutes;
                    $overtime_minutes = 0;
                } else {
                    $total_regular_minutes = 8 * 60;
                }

            }
            elseif ($request->attendance == "official_vacation_yes") {
//                dd(1);
                $hrs1 = (new Carbon($request->from1))->diff(new Carbon($request->to1))->format('%H:%I');
                $hrs2 = (new Carbon($request->from2))->diff(new Carbon($request->to2))->format('%H:%I');
                $total_daily_minutes = (new Carbon($request->from1))->diffInMinutes(new Carbon($request->to1)) + (new Carbon($request->from2))->diffInMinutes(new Carbon($request->to2));
                $overtime_minutes = $total_daily_minutes - (8 * 60);

                if ($overtime_minutes < 0) {
                    $total_regular_minutes = $total_daily_minutes;
                    $overtime_minutes = 0;
                } else {
                    $total_regular_minutes = 8 * 60;
                }
                // add 8 hours of vacation to total_daily_minutes
                $total_daily_minutes += 8 * 60;
            }
            elseif ($request->attendance == "official_vacation_no") {
//                dd(1);
                $hrs1 = null;
                $hrs2 = null;
                $overtime_minutes = null;


                // add 8 hours of vacation to total_daily_minutes
                $total_daily_minutes = 8 * 60;
                $total_regular_minutes = 8 * 60;

            }
            elseif ($request->attendance == "normal_vacation") {
//                dd(1);
                $hrs1 = null;
                $hrs2 = null;
                $overtime_minutes = null;


                // add 8 hours of vacation to total_daily_minutes
                $total_daily_minutes = 8 * 60;
                $total_regular_minutes = 8 * 60;

            }
            elseif ($request->attendance == "casual_vacation") {
//                dd(1);
                $hrs1 = null;
                $hrs2 = null;
                $overtime_minutes = null;


                // add 8 hours of vacation to total_daily_minutes
                $total_daily_minutes = 8 * 60;
                $total_regular_minutes = 8 * 60;

            }
            else {
//                dd(2);
                $request->reward = 0;
                $hrs1 = null;
                $hrs2 = null;
                $total_daily_minutes = null;
                $overtime_minutes = null;
                $total_regular_minutes = null;
            }


            foreach ($request->ids as $id) {
                $row = EmployeeTimeSheet::find($id);
                $employee = $row->employee;
                //update employee vacation number if i changed vacation restore old value
                if ($row->attendance == 'normal_vacation') {
                    $vacation = $row->total_regular_minutes / $total_regular_minutes;
                    $employee->update([
                        'normal_vacation_no' => $employee->normal_vacation_no + $vacation
                    ]);
                } elseif ($row->attendance == 'casual_vacation') {
                    $vacation = $row->total_regular_minutes / $total_regular_minutes;
                    $employee->update([
                        'casual_vacation_no' => $employee->casual_vacation_no + $vacation
                    ]);
                }

                //update employee vacation
                if ($request->attendance == "normal_vacation") {
                    if ($employee->normal_vacation_no > 0) {
                        if ($employee->normal_vacation_no < 1) {
                            $total_daily_minutes = $total_daily_minutes * $employee->normal_vacation_no;
                            $total_regular_minutes = $total_regular_minutes * $employee->normal_vacation_no;

                            // update employee normal_vacation_no
                            $employee->update([
                                'normal_vacation_no' => 0
                            ]);
                        } else {
                            // update employee normal_vacation_no
                            $employee->update([
                                'normal_vacation_no' => $employee->normal_vacation_no - 1
                            ]);
                        }
                    } else {
                        DB::rollBack();
                        return back()->withErrors(trans('main.an_employee_is_not_have_enough_vacation_balance'))->withInput();
                    }

                } elseif ($request->attendance == "casual_vacation") {
                    if ($employee->casual_vacation_no > 0) {
                        if ($employee->casual_vacation_no < 1) {
                            $total_daily_minutes = $total_daily_minutes * $employee->casual_vacation_no;
                            $total_regular_minutes = $total_regular_minutes * $employee->casual_vacation_no;

                            // update employee casual_vacation_no
                            $employee->update([
                                'casual_vacation_no' => 0
                            ]);
                        } else {
                            // update employee casual_vacation_no
                            $employee->update([
                                'casual_vacation_no' => $employee->casual_vacation_no - 1
                            ]);
                        }
                    } else {
                        DB::rollBack();
                        return back()->withErrors(trans('main.an_employee_is_not_have_enough_vacation_balance'))->withInput();
                    }
                }

                $hourly_salary = $row->hourly_salary;
                $total_regular = ($total_regular_minutes / 60) * $hourly_salary;
                $overtime = ($overtime_minutes / 60) * $hourly_salary;
                $total_daily = ($total_daily_minutes / 60) * $hourly_salary;
                $row->update([
//                    'date' => $request->date,
//                    'employee_id' => $id,
                    'attendance' => $request->attendance,
                    'from1' => $request->from1,
                    'to1' => $request->to1,
                    'from2' => $request->from2,
                    'to2' => $request->to2,
                    'hrs1' => $hrs1,
                    'hrs2' => $hrs2,

                    'total_regular_minutes' => $total_regular_minutes,
                    'overtime_minutes' => $overtime_minutes,
                    'total_daily_minutes' => $total_daily_minutes,

                    'hourly_salary' => $hourly_salary,
                    'total_regular' => $total_regular,
                    'overtime' => $overtime,
                    'reward' => $request->reward,
                    'total_daily' => $total_daily,
                    'details' => $request->details,
                ]);

                activity()
                    ->performedOn($row)
                    ->causedBy(auth()->user())
                    ->log('worker time sheet  :subject.id updated ');
            }

            DB::commit();
//            return 1;
            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/employee-time-sheet-history');


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

    public function destroy($id)
    {

        $row = EmployeeTimeSheet::findOrFail($id);
        if ($row->accounting_id != null) {
            toastr()->error(trans('main.u_cant_delete'));
            return back();
        }


        $row->delete();
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The Employee time sheet :subject.id deleted');
        toastr()->success(trans('main.delete_done_successfully'));
        return back();
    }
    public function destroyGET($id)
    {

        $row = EmployeeTimeSheet::findOrFail($id);
        if ($row->accounting_id != null) {
            toastr()->error(trans('main.u_cant_delete'));
            return back();
        }


        $row->delete();
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The Employee time sheet :subject.id deleted');
        toastr()->success(trans('main.delete_done_successfully'));
        return back();
    }
}
