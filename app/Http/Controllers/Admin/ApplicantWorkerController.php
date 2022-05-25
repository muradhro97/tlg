<?php

namespace App\Http\Controllers\Admin;

use App\ApplicantImage;
use App\ApplicantWorker;


use App\ApproveWorker;
use App\Imports\ApplicantWorkerImport;
use App\Job;
use App\Worker;
use App\WorkerImage;
use App\Models\Functions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;


class ApplicantWorkerController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('permission:allWorApp', ['only' => ['index']]);
        $this->middleware('permission:addWorApp', ['only' => ['create', 'store']]);
        $this->middleware('permission:editWorApp', ['only' => ['edit', 'update']]);
        $this->middleware('permission:deleteWorApp', ['only' => ['destroy']]);
//        $this->middleware('permission:actionEmpApp', ['only' => ['cancelApplicant', 'acceptEmployeeApplicant']]);

    }

    public function index(Request $request)
    {
        //
        $rows = ApplicantWorker::latest();
        if ($request->filled('name')) {
            $rows->where('name', 'like', "%$request->name%");


        }

        if ($request->filled('job_id')) {
            $rows->where('job_id', $request->job_id);


        }

        if ($request->filled('evaluation_status')) {
            $rows->where('evaluation_status', $request->evaluation_status);


        }

        $rows = $rows->paginate(20);

        return view('admin.applicant_worker.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ApplicantWorker $model)
    {
//        return "asa";
        return view('admin.applicant_worker.create', compact('model'));
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
//            'image' => 'image|mimes:jpg,jpeg,bmp,png',
//            'birth_date' => 'required|date|date_format:Y-m-d',
//            'start_date' => 'required|date|date_format:Y-m-d',
            'name' => 'required|max:255|unique:applicants,name',
            'nationality_no' => 'required|max:255|unique:applicants,nationality_no',
            'job_id' => 'required|exists:jobs,id',
//            'nationality_id' => 'required|exists:countries,id',
//            'nationality_no' => 'required|max:255',
            'mobile' => 'required|max:255',

//            'gender' => 'required|in:male,female',
//            'mentality' => 'required|in:normal,chronic,disease,ostensible',
//            'medical' => 'required|in:normal,upnormal',
//            'technical' => 'required|in:expert,professional,good,low,no_experience',
//            'weight' => 'required|in:weak,fit,over_weight',

//            'bank_id' => 'required|exists:banks,id',
//            'bank_account' => 'required|max:255',
//            'start_salary' => 'required|numeric|min:0',
//            'daily_salary' => 'required|numeric|min:0',
//            'working_status' => 'required||in:work,fired,resigned,retired',
//            'university_id' => 'required|exists:universities,id',
//            'department_id' => 'required|exists:labors_departments,id',
//            'organization_id' => 'required|exists:organizations,id',
            'project_id' => 'required|exists:projects,id',

//            'images.*' => 'image|mimes:jpg,jpeg,bmp,png',
//            'items.*' => 'required',


        ];
        if ($request->image  != null and $request->has('image')) {
//dd(9999);
            $rules['image'] = 'image|mimes:jpg,jpeg,bmp,png';
        }
        if ($request->images != null and count(array_filter($request->images)) >0 ) {
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

//return  $images = $request->file('images');
        DB::beginTransaction();
        try {
            $request->merge(['type' => 'worker']);
            $row = ApplicantWorker::create($request->all());
//        $client->roles()->sync($request->input('role'));
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                foreach ($images as $image) {
                    $this->addImage($image, $row->id, 'uploads/applicants/');

                }
            }
            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('The worker application :subject.name created');
            DB::commit();
            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/applicant-worker');

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
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $row = ApplicantWorker::find($id);

        return view('admin.applicant_worker.show', compact('row'));
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
        $model = ApplicantWorker::findOrFail($id);
        return view('admin.applicant_worker.edit', compact('model'));
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
//            'birth_date' => 'required|date|date_format:Y-m-d',
            'name' => 'required|max:255|unique:applicants,name,' . $id,
            'nationality_no' => 'required|max:255|unique:applicants,nationality_no,' . $id,
            'mobile' => 'required|max:255',
//            'gender' => 'required||in:male,female',
//            'mentality' => 'required||in:normal,chronic,disease,ostensible',
//            'medical' => 'required||in:normal,upnormal',
//            'technical' => 'required||in:expert,professional,good,low,no_experience',
//            'weight' => 'required||in:weak,fit,over_weight',
            'job_id' => 'required|exists:jobs,id',
//            'nationality_id' => 'required|exists:countries,id',
//            'nationality_no' => 'required|max:255',
//            'bank_id' => 'required|exists:banks,id',
//            'bank_account' => 'required|max:255',
//            'start_salary' => 'required|numeric|min:0',
//            'working_status' => 'required||in:work,fired,resigned,retired',
//            'university_id' => 'required|exists:universities,id',
//            'department_id' => 'required|exists:departments,id',
//            'organization_id' => 'required|exists:organizations,id',
            'project_id' => 'required|exists:projects,id',

//            'images.*' => 'image|mimes:jpg,jpeg,bmp,png',

        ];

        if ($request->image  != null and $request->has('image')) {
//dd(9999);
            $rules['image'] = 'image|mimes:jpg,jpeg,bmp,png';
        }
        if ($request->images != null and count(array_filter($request->images)) >0 ) {
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
            $row = ApplicantWorker::findOrFail($id);
//        $request->merge(['salary' => $request->start_salary * 0.75 ]);
            $row->update($request->all());
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                foreach ($images as $image) {
                    $this->addImage($image, $row->id, 'uploads/applicants/');

                }
            }
            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('The worker application :subject.name updated');
            DB::commit();

//        $client->roles()->sync($request->role);
            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/applicant-worker');
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

        $row = ApplicantWorker::findOrFail($id);


        $row->delete();
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The worker application :subject.name deleted');
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
        $addImage = new ApplicantImage;
        $addImage->image = $path . $name;
        $addImage->image_thumb = $path_thumb . $name;
        $addImage->applicant_id = $id;
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

    public function cancelWorkerApplicant(Request $request)
    {
        $this->validate($request, [
//            'user_name' => 'required|unique:users,user_name',
            'reason' => 'required',


        ]);
        $row = ApplicantWorker::find($request->id);

        $row->reason = $request->reason;
        if ($request->type === "reject") {
            $row->evaluation_status = "reject";
            $row->save();
            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('The worker application :subject.name rejected');
            toastr()->success(trans('main.reject_done_successfully'));

        } else if ($request->type === "delay") {
//            $row->deliver_driver_id = $request->driver_id;
            $row->evaluation_status = "delay";
            $row->save();
            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('The worker application :subject.name delayed');
            toastr()->success(trans('main.delay_done_successfully'));
        }


        return back();


    }

    public function acceptWorkerApplicant(Request $request)
    {
//dd(2);

        $row = ApplicantWorker::findOrFail($request->id);
        $row->evaluation_status = "accept";

        $row->save();
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The worker application :subject.name accepted');
        toastr()->success(trans('main.delay_done_successfully'));
        return back();

    }



    public function approveWorkerApplicant(Request $request)
    {
//        dd(123);

//        $row = ApplicantWorker::find(8);
//return base_path($row->image) ;
//       return explode(".",$row->image)[1];
//dd($validator);
        DB::beginTransaction();
        try {
            $row = ApplicantWorker::findOrFail($request->id);
            $row->evaluation_status = "approve";
            $row->save();
//        $request->merge(['salary' => $request->start_salary * 0.75 ]);
            $employee = new ApproveWorker();

            $employee->name = $row->name;
            $employee->job_id = $row->job_id;
            $employee->nationality_no = $row->nationality_no;
            $employee->nationality_id = $row->nationality_id;
            $employee->social_status = $row->social_status;
            $employee->military_status = $row->military_status;
            $employee->project_id = $row->project_id;
            $employee->organization_id = $row->organization_id;
            $employee->gender = $row->gender;
            $employee->address = $row->address;
            $employee->birth_date = $row->birth_date;
            $employee->mobile = $row->mobile;
            $employee->email = $row->email;
            $employee->applicant_id = $row->id;
            $employee->save();
            $employee->image = base_path($row->image);
            $path = 'uploads/workers/';
            $image = $this->copyImage($row->image, $path, '');
            if ($image) {
                $employee->image = $image;
            }
            $image_thumb = $this->copyImage($row->image_thumb, $path, 'thumb_');
            if ($image_thumb) {
                $employee->image_thumb = $image_thumb;
            }

            $job = Job::where('id', $employee->job_id)->first();
            $check= Worker::where('job_id',$employee->job_id)->where('id','<',$employee->id)->count();
            $no= $check +1;
            $abbreviation = $job->abbreviation ??'error';
            $employee->unique_no = $abbreviation . $no;
            $employee->save();

//            $job = Job::where('id', $row->job_id)->first();
//            $abbreviation = $job->abbreviation ??'error';
//            $employee->unique_no = $abbreviation . $row->id;
//            $employee->save();
            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('The worker application :subject.name approved');

            DB::commit();

//        $client->roles()->sync($request->role);
            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/applicant-worker/' . $request->id);
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

    public static function copyImage($name, $destination, $name_start)
    {
        $sourcepath = base_path($name);
        if (file_exists($sourcepath) and $name != '') {
//            $path='uploads/applicants/';
            $destinationpath = $destination . $name_start . time() . '' . rand(11111, 99999) . '.' . explode(".", $name)[1];
            copy($sourcepath, $destinationpath);
            return $destinationpath;
        }

        return false;
    }

    public function import(Worker $model)
    {
//        return "asa";
//        $aa=  Excel::import(new ApplicantWorkerImport, 'aa.xlsx');
//        dd($aa);
        return view('admin.applicant_worker.import', compact('model'));
    }

    public function importSave(Request $request)
    {
        $rules = [
            'file' => 'required|mimes:xlsx,xls',



        ];
        validator()->make($request->all(), $rules);
//        dd($request->file('file'));
        Excel::import(new ApplicantWorkerImport, $request->file('file'));
        toastr()->success(trans('main.import_done_successfully'));
        return back();
    }
}
