<?php

namespace App\Http\Controllers\Admin;

use App\Employee;


use App\Employee_change_log;
use App\EmployeeImage;
use App\Exports\EmployeeExport;
use App\Exports\WorkersExport;
use App\Job;
use App\Models\Functions;
use App\Project;
use App\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;


class EmployeeController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('permission:allEmp', ['only' => ['index']]);
        $this->middleware('permission:addEmp', ['only' => ['create', 'store']]);
        $this->middleware('permission:editEmp', ['only' => ['edit', 'update']]);
        $this->middleware('permission:deleteEmp', ['only' => ['destroy']]);


    }
    public function exportExcel(Request $request)
    {
        $response = Excel::download(new EmployeeExport($request), 'employees.xlsx');
        ob_end_clean();

        return $response;
    }

    public function index(Request $request)
    {
        //
//return 55;
//        $rowss= Employee::all();
//        foreach($rowss as $row){
//            $job = Job::where('id', $row->job_id)->first();
//            $check = Employee::where('job_id', $job->id)->max('unique_no_helper') ?? 0;
////            $check= Employee::where('job_id',$row->job_id)->where('id','<',$row->id)->count();
//            $no= $check +1;
//
//            $abbreviation = $job->abbreviation ??'error';
//            $row->unique_no = $abbreviation . $no;
//            $row->unique_no_helper =  $no;
//            $row->save();
//
//        }
//        return 'done';
//        $rowss= Employee::all();
//        foreach($rowss as $row){
//            $job = Job::where('id', $row->job_id)->first();
//            $abbreviation = $job->abbreviation ??'error';
//            $row->unique_no = $abbreviation . $row->id;
//            $row->save();
//
//        }
        $projects = auth()->user()->projects->pluck('id')->toArray();
        $rows = Employee::latest()->whereIn('project_id', $projects);
        if ($request->filled('name')) {
            $rows->where('name', 'like', "%$request->name%");


        }

        if ($request->filled('job_id')) {
            $rows->where('job_id', $request->job_id);


        }
        if ($request->filled('project_id')) {
            $rows->where('project_id', $request->project_id);


        }

        if ($request->filled('organization_id')) {
            $rows->where('organization_id', $request->organization_id);
        }
        if ($request->filled('department_id')) {
            $rows->where('department_id', $request->department_id);
        }
        if ($request->filled('working_status')) {
            $rows->where('working_status', $request->working_status);
        }
        if ($request->filled('social_status')) {
            $rows->where('social_status', $request->social_status);
        }
        if ($request->filled('military_status')) {
            $rows->where('military_status', $request->military_status);
        }



        $rows = $rows->paginate(20);

        return view('admin.employee.index', compact('rows','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Employee $model)
    {
//        return "asa";
        return view('admin.employee.create', compact('model'));
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

        $rules = [
            'image' => 'required|image|mimes:jpg,jpeg,bmp,png',
            'name' => 'required|max:255',

            'job_id' => 'required|exists:jobs,id',
            'nationality_id' => 'required|exists:countries,id',
            'nationality_no' => 'required|max:255',
            'social_status' => 'required|in:single,married,divorced,widowed',
            'military_status' => 'required|in:exemption,done,delayed',
            'gender' => 'required|in:male,female',
            'address' => 'required|max:255',
            'current_address' => 'required|max:255',
            'birth_date' => 'required|date|date_format:Y-m-d',

            'mobile' => 'required|max:255',
            'qualification_title' => 'required|max:255',
            'university_id' => 'required|exists:universities,id',
            'graduation_year' => 'required|numeric|min:0',


            'organization_id' => 'required|exists:organizations,id',
            'start_salary' => 'required|numeric|min:0',
            'project_id' => 'required|exists:projects,id',
            'current_salary' => 'required|numeric|min:0',
            'department_id' => 'required|exists:departments,id',
            'start_date' => 'required|date|date_format:Y-m-d',

            'working_status' => 'required|in:work,fired,resigned,retired,not_started',
//            'bank_id' => 'required|exists:banks,id',
//            'bank_account' => 'required|max:255',
//            'daily_salary' => 'required|numeric|min:0',
            'hourly_salary' => 'required|numeric|min:0',
            'insurance' => 'required|numeric|min:0',
            'taxes' => 'required|numeric|min:0',
            'meals' => 'required|numeric|min:0',
            'communications' => 'required|numeric|min:0',
            'transports' => 'required|numeric|min:0',
            'images.*' => 'image|mimes:jpg,jpeg,bmp,png',
//            'items.*' => 'required',


        ];

        if ($request->filled('email')) {
            $rules['email'] = 'email|max:255';
        }
        $validator = validator()->make($request->all(), $rules);
//        $validator->after(function ($validator) use ($request) {
////          return  $request->items;
//            if (count(array_filter($request->items)) < 1) {
//
//                $validator->errors()->add('items', trans('main.please_add_item'));
//            }
//        });

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();


        }

//return  $images = $request->file('images');
        DB::beginTransaction();
        try {
            $request->merge(['salary' => $request->start_salary * 0.75]);
            $row = Employee::create($request->all());

            $job = Job::where('id', $row->job_id)->first();
            $check = Employee::where('job_id', $job->id)->max('unique_no_helper') ?? 0;
//            $check= Employee::where('job_id',$row->job_id)->where('id','<',$row->id)->count();
            $no= $check +1;
            $abbreviation = $job->abbreviation ??'error';
            $row->unique_no = $abbreviation . $no;
            $row->unique_no_helper = $no;

            // Calculate Vacation days
            $current_month = Carbon::createFromFormat('Y-m-d', $row->start_date)->month;
            $remaining_months_in_year = 12 -$current_month;
            $normal_days = (21 * $remaining_months_in_year)/12;
            $casual_days = (7 * $remaining_months_in_year)/12;

            $row->normal_vacation_no = round($normal_days);
            $row->casual_vacation_no = round($casual_days);

            $row->save();

//            $job = Job::where('id', $request->job_id)->first();
//            $abbreviation = $job->abbreviation ??'error';
//            $row->unique_no = $abbreviation . $row->id;
//            $row->save();
//            $client->roles()->sync($request->input('role'));
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                foreach ($images as $image) {
                    $this->addImage($image, $row->id, 'uploads/employees/');

                }
            }
            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('The employee :subject.name created');
            DB::commit();
            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/employee');

        } catch (\Exception $e) {
            DB::rollBack();
//
//            return $e->getMessage();
            flash()->error($e->getMessage());

            return back()->withInput();


        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();
//return $ex->errorInfo[2];
            flash()->error($ex->errorInfo[2]);

            return back()->withInput();

        }
    }


    public function show($id , Request $request)
    {
        $row = Employee::find($id);

        $salaries = $row->employee_salary_details()->whereHas('accounting',function ($query)use ($request){
            $query->where([
                'manager_status'    =>  'accept',
                'payment_status'    =>  'confirmed',
            ]);
            if ($request->filled('date')) {
                $date = $request->date;
                $query->whereMonth('date', Carbon::parse($date))
                    ->whereYear('date', Carbon::parse($date));
            }
            return $query;
        })->get();

        $time_sheet = $row->timeSheet();

        if ($request->filled('from')) {
            $time_sheet->where('date', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $time_sheet->where('date', '<=', $request->to);
        }
        $time_sheet = $time_sheet->get();

        return view('admin.employee.show', compact('row','salaries','time_sheet'));
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
        $model = Employee::findOrFail($id);
        return view('admin.employee.edit', compact('model'));
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
//        return $request->all();
//        return $request->image;
//        return array_filter($request->images);
        $rules = [
//            'image' => 'image|mimes:jpg,jpeg,bmp,png',
            'name' => 'required|max:255',

            'job_id' => 'required|exists:jobs,id',
            'nationality_id' => 'required|exists:countries,id',
            'nationality_no' => 'required|max:255',
            'social_status' => 'required|in:single,married,divorced,widowed',
            'military_status' => 'required|in:exemption,done,delayed',
            'gender' => 'required|in:male,female',
            'address' => 'required|max:255',
            'current_address' => 'required|max:255',
            'birth_date' => 'required|date|date_format:Y-m-d',

            'mobile' => 'required|max:255',
            'qualification_title' => 'required|max:255',
            'university_id' => 'required|exists:universities,id',
            'graduation_year' => 'required|numeric|min:0',


            'organization_id' => 'required|exists:organizations,id',
            'start_salary' => 'required|numeric|min:0',
            'project_id' => 'required|exists:projects,id',
            'current_salary' => 'required|numeric|min:0',
            'department_id' => 'required|exists:departments,id',
            'start_date' => 'required|date|date_format:Y-m-d',

            'hourly_salary' => 'required|numeric|min:0',
            'insurance' => 'required|numeric|min:0',
            'taxes' => 'required|numeric|min:0',
            'meals' => 'required|numeric|min:0',
            'communications' => 'required|numeric|min:0',
            'transports' => 'required|numeric|min:0',
            'working_status' => 'required|in:work,fired,resigned,retired,not_started',

//            'images.*' => 'image|mimes:jpg,jpeg,bmp,png',

        ];

        if ($request->image != null and $request->has('image')) {
//dd(9999);
            $rules['image'] = 'image|mimes:jpg,jpeg,bmp,png';
        }
        if ($request->images != null and count(array_filter($request->images)) > 0) {
            $rules['images.*'] = 'image|mimes:jpg,jpeg,bmp,png';
//            dd($request->images);
        }
        $validator = validator()->make($request->all(), $rules);
//        $validator->after(function ($validator) use ($request) {
////          return  $request->items;
//            if (count(array_filter($request->items)) < 1) {
//
//                $validator->errors()->add('items', trans('main.please_add_item'));
//            }
//        });

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();


        }

//dd($validator);
        DB::beginTransaction();
        try {
            $row = Employee::findOrFail($id);


            // save change log
            if ($request->job_id != $row->job_id){
                $change_log = new Employee_change_log([
                    'change_type'   =>   'job',
                    'change_value'  =>  Job::findOrFail($row->job_id)->name,
                    'new_value' => Job::findOrFail($request->job_id)->name,
                    'employee_id' =>  $row->id
                ]);
                $change_log->save();
            }

            if ($request->project_id != $row->project->id){
                $change_log = new Employee_change_log([
                    'change_type'   =>   'project',
                    'change_value'  =>  $row->project->name,
                    'new_value' => Project::findOrFail($request->project_id)->name,
                    'employee_id' =>  $row->id
                ]);
                $change_log->save();
            }

            if ($request->working_status != $row->working_status){
                $change_log = new Employee_change_log([
                    'change_type'   =>   'working status',
                    'change_value'  =>  $row->working_status,
                    'new_value' => $request->working_status,
                    'employee_id' =>  $row->id
                ]);
                $change_log->save();
            }

//        $request->merge(['salary' => $request->start_salary * 0.75 ]);
            $row->update($request->all());
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                foreach ($images as $image) {
                    $this->addImage($image, $row->id, 'uploads/employees/');

                }
            }
            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('The employee :subject.name updated');
            DB::commit();

//        $client->roles()->sync($request->role);
            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/employee');
        } catch (\Exception $e) {
            DB::rollBack();
//
//            return $e->getMessage();
            flash()->error($e->getMessage());

            return back()->withInput();


        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();
//return $ex->errorInfo[2];
            flash()->error($ex->errorInfo[2]);

            return back()->withInput();

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $row = Employee::findOrFail($id);


        $row->delete();
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The employee :subject.name name');
        toastr()->success(trans('main.delete_done_successfully'));
        return back();

    }


    public static function addImage($image, $id, $path)
    {
        $path_thumb = $path . 'thumb_';
        $name = time() . '' . rand(11111, 99999) . '.' . $image->getClientOriginalExtension();
        $img = Image::make($image);

        $img->save($path . $name);

        $img->widen(100, null);

        $img->save($path_thumb . $name);
        $addImage = new EmployeeImage;
        $addImage->image = $path . $name;
        $addImage->image_thumb = $path_thumb . $name;
        $addImage->employee_id = $id;
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

    public function employeePrint($id)
    {
        //
        $settings = Setting::findOrNew(1);
        $row = Employee::where('id', $id);

        $row = $row->first();
        if (!$row) {
            abort(404);
        }
        return view('admin.employee.employee_print', compact('row', 'settings'));
    }

    public function employeePrintDetails( $id)
    {



        $row = Employee::find($id);
        return view('admin.employee.details_print', compact('row'));
    }

}
