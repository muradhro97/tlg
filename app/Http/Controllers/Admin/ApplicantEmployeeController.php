<?php

namespace App\Http\Controllers\Admin;

use App\ApplicantImage;
use App\ApplicantEmployee;


use App\ApproveEmployee;
use App\Employee;
use App\Job;
use App\Setting;
use App\WorkerImage;
use App\Models\Functions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;


class ApplicantEmployeeController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('permission:allEmpApp', ['only' => ['index']]);
        $this->middleware('permission:addEmpApp', ['only' => ['create', 'store']]);
        $this->middleware('permission:editEmpApp', ['only' => ['edit', 'update']]);
        $this->middleware('permission:deleteEmpApp', ['only' => ['destroy']]);
        $this->middleware('permission:actionEmpApp', ['only' => ['cancelApplicant', 'acceptEmployeeApplicant']]);

    }

    public function index(Request $request)
    {
        //
        $rows = ApplicantEmployee::latest();
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

        return view('admin.applicant_employee.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ApplicantEmployee $model)
    {
//        return "asa";
        return view('admin.applicant_employee.create', compact('model'));
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
//            'image' => 'required|image|mimes:jpg,jpeg,bmp,png',
            'name' => 'required|max:255|unique:applicants,name',
//            'birth_date' => 'required|date|date_format:Y-m-d',
            'mobile' => 'required|max:255',
//            'educations' => 'required',
//            'email' => 'required|email|max:255',
//            'start_date' => 'required|date|date_format:Y-m-d',
//            'gender' => 'in:male,female',
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
//            'daily_salary' => 'required|numeric|min:0',
//            'university_id' => 'required|exists:universities,id',
//            'department_id' => 'required|exists:labors_departments,id',
//            'organization_id' => 'required|exists:organizations,id',
//            'project_id' => 'required|exists:projects,id',
//            'working_status' => 'required|in:work,fired,resigned',
//            'military_status' => 'required|in:exemption,done,delayed',
//            'experience_years' => 'required',
//            'last_salary' => 'required|numeric|min:0',
//            'expected_salary' => 'required|numeric|min:0',
//            'courses' => 'required',
//            'skills' => 'required',
//            'abilities' => 'required',
//            'overview' => 'required',
//            'reasons' => 'required',
//            'notes' => 'required',
//            'work_history' => 'required',
//            'position' => 'required|max:255',
//            'university_id' => 'required|exists:universities,id',
//            'graduation_year' => 'required|numeric|min:0',

//            'images.*' => 'image|mimes:jpg,jpeg,bmp,png',
//            'items.*' => 'required',


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
        $validator->after(function ($validator) use ($request) {
////          return  $request->items;
//            if (count(array_filter($request->items)) < 1) {
//
//                $validator->errors()->add('items', trans('main.please_add_item'));
//            }

            if (count(json_decode($request->educations)) < 1) {
//            if (count(array_filter($request->items)) < 1) {

                $validator->errors()->add('educations', trans('main.educations_required'));
            }
        });

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();


        }

//return  $images = $request->file('images');
        DB::beginTransaction();
        try {
            $request->merge(['type' => 'employee']);
            $row = ApplicantEmployee::create($request->all());
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
                ->log('The employee application :subject.name created');
            DB::commit();
            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/applicant-employee');

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
        $row = ApplicantEmployee::find($id);

        return view('admin.applicant_employee.show', compact('row'));
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
        $model = ApplicantEmployee::findOrFail($id);
//        $educationsJs = array();
        $educationsJs = json_encode(json_decode($model->educations, false));
        $experiencesJs = json_encode(json_decode($model->experiences, false));
//       return  $educationsJs= ($model->educations);
//           $experiencesJs= json_decode($model->experiences,false);
        return view('admin.applicant_employee.edit', compact('model', 'educationsJs', 'experiencesJs'));
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
//            'email' => 'required|email|max:255',
//            'start_date' => 'required|date|date_format:Y-m-d',
//            'name' => 'required|max:255',
//            'user_name' => 'required|unique:applicants,user_name,' . $id,
            'name' => 'required|max:255|unique:applicants,name,' . $id,
            'mobile' => 'required|max:255',
            'educations' => 'required',
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
//            'daily_salary' => 'required|numeric|min:0',
//            'university_id' => 'required|exists:universities,id',
//            'department_id' => 'required|exists:labors_departments,id',
//            'organization_id' => 'required|exists:organizations,id',
//            'project_id' => 'required|exists:projects,id',
//            'working_status' => 'required|in:work,fired,resigned',
//            'military_status' => 'required|in:exemption,done,delayed',
//            'experience_years' => 'required',
//            'last_salary' => 'required|numeric|min:0',
//            'expected_salary' => 'required|numeric|min:0',
//            'courses' => 'required',
//            'skills' => 'required',
//            'abilities' => 'required',
//            'overview' => 'required',
//            'reasons' => 'required',
//            'notes' => 'required',
//            'work_history' => 'required',
//            'position' => 'required|max:255',
//            'university_id' => 'required|exists:universities,id',
//            'graduation_year' => 'required|numeric|min:0',

//            'images.*' => 'image|mimes:jpg,jpeg,bmp,png',
//            'items.*' => 'required',


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
        $validator->after(function ($validator) use ($request) {
////          return  $request->items;
//            if (count(array_filter($request->items)) < 1) {
//
//                $validator->errors()->add('items', trans('main.please_add_item'));
//            }
            if (count(json_decode($request->educations)) < 1) {
//            if (count(array_filter($request->items)) < 1) {

                $validator->errors()->add('educations', trans('main.educations_required'));
            }
        });

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();


        }

//dd($validator);
        DB::beginTransaction();
        try {
            $row = ApplicantEmployee::findOrFail($id);
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
                ->log('The employee application :subject.name updated');
            DB::commit();

//        $client->roles()->sync($request->role);
            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/applicant-employee');
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

        $row = ApplicantEmployee::findOrFail($id);


        $row->delete();
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The employee application :subject.name deleted');
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

    public function cancelEmployeeApplicant(Request $request)
    {
        $this->validate($request, [
//            'user_name' => 'required|unique:users,user_name',
            'reason' => 'required',


        ]);
        $row = ApplicantEmployee::find($request->id);

        $row->reason = $request->reason;
        if ($request->type === "reject") {
            $row->evaluation_status = "reject";
            $row->save();
            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('The employee application :subject.name reject');
            toastr()->success(trans('main.reject_done_successfully'));

        } else if ($request->type === "delay") {
//            $row->deliver_driver_id = $request->driver_id;
            $row->evaluation_status = "delay";
            $row->save();
            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('The employee application :subject.name delayed');
            toastr()->success(trans('main.delay_done_successfully'));
        }


        return back();


    }

    public function acceptEmployeeApplicant($id)
    {
//dd(2);

        $model = ApplicantEmployee::findOrFail($id);
        return view('admin.applicant_employee.accept_applicant', compact('model'));

    }

    public function acceptEmployeeApplicantSave(Request $request, $id)
    {

        $rules = [

            'start_date' => 'required|date|date_format:Y-m-d',
            'location' => 'required|max:255',
            'test_period' => 'required|max:255',
            'basic_salary' => 'required|max:255',
            'test_salary' => 'required|max:255',
            'allowances' => 'required|max:255',
            'job_description' => 'required',
            'papers_needed' => 'required',
        ];

        $validator = validator()->make($request->all(), $rules);


        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();


        }

//dd($validator);
        DB::beginTransaction();
        try {
            $row = ApplicantEmployee::findOrFail($id);
//        $request->merge(['salary' => $request->start_salary * 0.75 ]);

            $request->merge(['evaluation_status' => 'accept']);
            $row->update($request->all());



//        $client->roles()->sync($request->role);
            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('The employee application :subject.name accepted');
            DB::commit();
            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/applicant-employee/' . $id);
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

    public function approveEmployeeApplicant(Request $request)
    {
//        dd(123);

//        $row = ApplicantEmployee::find(8);
//return base_path($row->image) ;
//       return explode(".",$row->image)[1];
//dd($validator);
        DB::beginTransaction();
        try {
            $row = ApplicantEmployee::findOrFail($request->id);
            $row->evaluation_status = "approve";
            $row->save();
//        $request->merge(['salary' => $request->start_salary * 0.75 ]);
            $employee = new ApproveEmployee();

            $employee->name = $row->name;
            $employee->job_id = $row->job_id;
            $employee->nationality_no = $row->nationality_no;
            $employee->nationality_id = $row->nationality_id;
            $employee->social_status = $row->social_status;
            $employee->military_status = $row->military_status;
            $employee->gender = $row->gender;
            $employee->address = $row->address;
            $employee->birth_date = $row->birth_date;
            $employee->mobile = $row->mobile;
            $employee->email = $row->email;
            $employee->applicant_id = $row->id;
            $employee->save();
            $employee->image = base_path($row->image);
            $path = 'uploads/employees/';
            $image = $this->copyImage($row->image, $path, '');
            if ($image) {
                $employee->image = $image;
            }
            $image_thumb = $this->copyImage($row->image_thumb, $path, 'thumb_');
            if ($image_thumb) {
                $employee->image_thumb = $image_thumb;
            }

            $job = Job::where('id', $employee->job_id)->first();
            $check= Employee::where('job_id',$employee->job_id)->where('id','<',$employee->id)->count();
            $no= $check +1;
            $abbreviation = $job->abbreviation ??'error';
            $employee->unique_no = $abbreviation . $no;
            $employee->save();
//
//            $job = Job::where('id', $row->job_id)->first();
//            $abbreviation = $job->abbreviation ??'error';
//            $employee->unique_no = $abbreviation . $row->id;
//
//            $employee->save();
            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('The employee application :subject.name approved');
            DB::commit();

//        $client->roles()->sync($request->role);
            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/applicant-employee/' . $request->id);
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
    public function printLetter($id)
    {
        //
        $settings = Setting::findOrNew(1);
        $row = ApplicantEmployee::where('id', $id);

        $row = $row->first();
        if (!$row) {
            abort(404);
        }
        return view('admin.applicant_employee.letter_print', compact('row', 'settings'));
    }
}
