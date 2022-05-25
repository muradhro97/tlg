<?php

namespace App\Http\Controllers\Admin;

use App\Exports\WorkersExport;
use App\Imports\ApplicantWorkerImport;
use App\Imports\WorkerImport;
use App\Job;
use App\Project;
use App\Setting;
use App\Worker;


use App\Worker_change_log;
use App\WorkerImage;
use App\Models\Functions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;


class WorkerController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('permission:allWor', ['only' => ['index']]);
        $this->middleware('permission:addWor', ['only' => ['create', 'store']]);
        $this->middleware('permission:editWor', ['only' => ['edit', 'update']]);
        $this->middleware('permission:deleteWor', ['only' => ['destroy']]);
    }

    public function exportExcel(Request $request)
    {
        $response = Excel::download(new WorkersExport($request), 'workers.xlsx');
        ob_end_clean();

        return $response;
    }

    public function index(Request $request)
    {
        //
//        $rowss= Worker::all();
//        foreach($rowss as $row){
//            $job = Job::where('id', $row->job_id)->first();
//            $check = Worker::where('job_id', $job->id)->max('unique_no_helper') ?? 0;
////            $check= Worker::where('job_id',$row->job_id)->where('id','<',$row->id)->count();
//            $no= $check +1;
//            $abbreviation = $job->abbreviation ??'error';
//            $row->unique_no = $abbreviation . $no;
//            $row->unique_no_helper =  $no;
//            $row->save();
//
//        }
//        return 'done';
        $projects = auth()->user()->projects->pluck('id')->toArray();
        $rows = Worker::latest()->whereIn('project_id', $projects);//            ->orWhereNull('project_id')

        if ($request->filled('name')) {
            $rows->where('name', 'like', "%$request->name%");
        }

        if ($request->filled('address')) {
            $rows->where('address', 'like', "%$request->address%");
        }

        if ($request->filled('job_id')) {
            $rows->where('job_id', $request->job_id);
        }

        if ($request->filled('nationality_no')) {
            $rows->where('nationality_no', $request->nationality_no);
        }

        if ($request->filled('site_id')) {
            $rows->where('site_id', $request->site_id);
        }

        if ($request->filled('worker_id')) {
            $rows->where('unique_no', $request->worker_id);
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
        if ($request->filled('labors_group_id')) {
            $rows->where('labors_group_id', $request->labors_group_id);
        }
        $rows = $rows->paginate(20);

        return view('admin.worker.index', compact('rows','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Worker $model)
    {
//        return "asa";
        return view('admin.worker.create', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $rules = [
            'image' => 'required|image|mimes:jpg,jpeg,bmp,png',
            'name' => 'required|max:255|unique:workers,name',

            'worker_classification_id' => 'required|exists:worker_classifications,id',
            'labors_group_id' => 'required|exists:labors_groups,id',
            'job_id' => 'required|exists:jobs,id',
            'nationality_id' => 'required|exists:countries,id',
            'nationality_no' => 'required|max:255|unique:workers,nationality_no',
            'social_status' => 'required|in:single,married,divorced,widowed',
            'military_status' => 'required|in:exemption,done,delayed',
            'gender' => 'required|in:male,female',
            'address' => 'required|max:255',
//            'current_address' => 'required|max:255',
            'birth_date' => 'required|date|date_format:Y-m-d',

            'mobile' => 'required|max:255',
//            'qualification_title' => 'required|max:255',
//            'university_id' => 'required|exists:universities,id',
//            'graduation_year' => 'required|numeric|min:0',


            'organization_id' => 'required|exists:organizations,id',
//            'start_salary' => 'required|numeric|min:0',
            'project_id' => 'required|exists:projects,id',
//            'daily_salary' => 'required|numeric|min:0',
            'department_id' => 'required|exists:labors_departments,id',
            'start_date' => 'required|date|date_format:Y-m-d',

            'working_status' => 'required|in:work,fired,resigned,retired,blacklist',
//            'bank_id' => 'required|exists:banks,id',
//            'bank_account' => 'required|max:255',
//            'daily_salary' => 'required|numeric|min:0',

            'images.*' => 'image|mimes:jpg,jpeg,bmp,png',


        ];
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
            $row = Worker::create($request->all());

            $job = Job::where('id', $row->job_id)->first();
            $check = Worker::where('job_id', $job->id)->max('unique_no_helper') ?? 0;
//            $check= Worker::where('job_id',$row->job_id)->where('id','<',$row->id)->count();
            $no = $check + 1;
            $abbreviation = $job->abbreviation ?? 'error';
            $row->unique_no = $abbreviation . $no;
            $row->unique_no_helper = $no;


            $row->save();

//            $job = Job::where('id', $request->job_id)->first();
//            $abbreviation = $job->abbreviation ??'error';
//            $row->unique_no = $abbreviation . $row->id;
//            $row->save();
//        $client->roles()->sync($request->input('role'));
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                foreach ($images as $image) {
                    $this->addImage($image, $row->id, 'uploads/workers/');

                }
            }
            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('The worker :subject.name created');
            DB::commit();
            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/worker');

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


    public function show($id ,Request $request)
    {
        $row = Worker::find($id);

        $salaries = $row->worker_salary_details()->whereHas('accounting',function ($query)use ($request){
            $query->where([
                'manager_status'    =>  'accept',
                'payment_status'    =>  'confirmed',
            ]);
            if ($request->filled('from')) {
                $query->where('start', '>=', $request->from);
            }

            if ($request->filled('to')) {
                $query->where('end', '<=', $request->to);
            }
            return $query;
        })->get();

        $time_sheet = $row->workerTimeSheet();
        if ($request->filled('from')) {
            $time_sheet->where('date', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $time_sheet->where('date', '<=', $request->to);
        }
        $time_sheet =$time_sheet->get();

        return view('admin.worker.show', compact('row' ,'salaries','time_sheet'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $model = Worker::findOrFail($id);
        return view('admin.worker.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
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
            'name' => 'required|max:255|unique:workers,name,' . $id,
            'worker_classification_id' => 'required|exists:worker_classifications,id',
            'job_id' => 'required|exists:jobs,id',
            'labors_group_id' => 'required|exists:labors_groups,id',
            'nationality_id' => 'required|exists:countries,id',
            'nationality_no' => 'required|max:255|unique:workers,nationality_no,' . $id,
            'social_status' => 'required|in:single,married,divorced,widowed',
            'military_status' => 'required|in:exemption,done,delayed',
            'gender' => 'required|in:male,female',
            'address' => 'required|max:255',
//            'current_address' => 'required|max:255',
            'birth_date' => 'required|date|date_format:Y-m-d',

            'mobile' => 'required|max:255',
//            'qualification_title' => 'required|max:255',
//            'university_id' => 'required|exists:universities,id',
//            'graduation_year' => 'required|numeric|min:0',


            'organization_id' => 'required|exists:organizations,id',
//            'start_salary' => 'required|numeric|min:0',
            'project_id' => 'required|exists:projects,id',
//            'daily_salary' => 'required|numeric|min:0',
            'department_id' => 'required|exists:labors_departments,id',
            'start_date' => 'required|date|date_format:Y-m-d',

            'working_status' => 'required|in:work,fired,resigned,retired,blacklist',

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
            $row = Worker::findOrFail($id);

            // save change log
            if ($request->job_id != $row->job_id) {
                $change_log = new Worker_change_log([
                    'change_type' => 'job',
                    'change_value' => Job::findOrFail($row->job_id)->name,
                    'new_value' => Job::findOrFail($request->job_id)->name,
                    'worker_id' => $row->id
                ]);
                $change_log->save();
            }

            if ($request->project_id != $row->project->id) {
                $change_log = new Worker_change_log([
                    'change_type' => 'project',
                    'change_value' => $row->project->name,
                    'new_value' => Project::findOrFail($request->project_id)->name,
                    'worker_id' => $row->id
                ]);
                $change_log->save();
            }

            if ($request->working_status != $row->working_status) {
                $change_log = new Worker_change_log([
                    'change_type' => 'working status',
                    'change_value' => $row->working_status,
                    'new_value' => $request->working_status,
                    'worker_id' => $row->id
                ]);
                $change_log->save();
            }

//        $request->merge(['salary' => $request->start_salary * 0.75 ]);
            $row->update($request->all());
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                foreach ($images as $image) {
                    $this->addImage($image, $row->id, 'uploads/workers/');

                }
            }
            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('The worker :subject.name updated');
            DB::commit();

//        $client->roles()->sync($request->role);
            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/worker');
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
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $row = Worker::findOrFail($id);


        $row->delete();
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The worker :subject.name deleted');
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
        $addImage = new WorkerImage;
        $addImage->image = $path . $name;
        $addImage->image_thumb = $path_thumb . $name;
        $addImage->worker_id = $id;
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

    public function import(Worker $model)
    {
//        return "asa";
//        $aa=  Excel::import(new ApplicantWorkerImport, 'aa.xlsx');
//        dd($aa);
        return view('admin.worker.import', compact('model'));
    }

    public function importSave(Request $request)
    {
        $rules = [
            'file' => 'required|mimes:xlsx,xls',


        ];
        validator()->make($request->all(), $rules);
//        dd($request->file('file'));
        Excel::import(new WorkerImport, $request->file('file'));
        toastr()->success(trans('main.import_done_successfully'));
        return back();
    }

    public function workerPrint($id)
    {
        //
        $settings = Setting::findOrNew(1);
        $row = Worker::where('id', $id);

        $row = $row->first();
        if (!$row) {
            abort(404);
        }
        return view('admin.worker.worker_print', compact('row', 'settings'));
    }

    public function workerPrintDetails($id)
    {
        $row = Worker::find($id);
        return view('admin.worker.details_print', compact('row'));
    }
}
