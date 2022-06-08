<?php

namespace App\Http\Controllers\Admin;

use App\AccountingImage;
use App\Exports\WorkerTimeSheetHistoryExport;
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

class WorkerTimeSheetController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('permission:addWorTime', ['only' => ['index', 'store']]);
        $this->middleware('permission:editWorTime', ['only' => ['edit', 'update','updateAll']]);
        $this->middleware('permission:deleteWorTime', ['only' => ['destroy','destroyGET']]);
        $this->middleware('permission:historyWorTime', ['only' => ['workerTimeSheetHistory']]);

    }

    public function workerTimeSheetProductivity(Request $request)
    {
        //
        $model = new WorkerTimeSheet();
        $projects = auth()->user()->projects->pluck('id')->toArray();
        $rows = Worker::latest()->where('working_status', 'work')->whereIn('project_id', $projects);
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
        if ($request->filled('date')) {
            $date = $request->date;
        } else {
            $date = Carbon::today();
        }
        $rows->whereDoesntHave('workerTimeSheet', function ($q) use ($date) {
            $q->where('date', $date);

        });


        $rows = $rows->paginate(20);

        return view('admin.worker_time_sheet.index_productivity', compact('rows', 'model'));
    }

    public function storeProductivity(Request $request)
    {

            //
//        return $items = json_decode($request->items);
//        return $request->all();
        $rules = [

            'date' => 'required|date|date_format:Y-m-d',


            'attendance' => 'required|in:yes,no',
            'productivity' => 'required|numeric|min:0',
//            'deduction_hrs' => 'numeric|min:0',
//            'safety' => 'numeric|min:0',


        ];


        $validator = validator()->make($request->all(), $rules);

        $validator->after(function ($validator) use ($request) {
            if ($request->ids) {

                if (count($request->ids) < 1) {

                    $validator->errors()->add('ids', trans('main.please_add_worker'));
                }
            } else {
                $validator->errors()->add('ids', trans('main.please_add_worker'));

            }
////          return  $request->items;
//            if (count(json_decode($request->items)) < 1) {
////            if (count(array_filter($request->items)) < 1) {
//
//                $validator->errors()->add('items', trans('main.please_add_item'));
//            }
        });
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();


        }
        DB::beginTransaction();
        try {

            foreach ($request->ids as $id) {
                $worker = Worker::find($id);
                if (!$worker) {
                    DB::rollBack();


                    return back()->withErrors(trans('main.server_error'))->withInput();
                }
                if ($request->attendance == "yes") {

                    $unit_price = $worker->workerClassification->unit_price ?? 1;

                    $productivity = $request->productivity;
                    $total = $productivity * $unit_price;
                } else {


                    $unit_price = null;
                    $productivity = null;

                    $total = null;
                }


                $row = WorkerTimeSheet::create([

                    'date' => $request->date,

                    'worker_id' => $id,
//                    'hourly_salary' => $hourly_salary,
//                    'daily_salary' => $daily_salary,
                    'attendance' => $request->attendance,
//                    'overtime' => $request->overtime,
//                    'deduction_hrs' => $request->deduction_hrs,
//                    'deduction_value' => $request->deduction_value,
//                    'safety' => $request->safety,
                    'details' => $request->details,
                    'type' => 'productivity',
                    'unit_price' => $unit_price,
                    'productivity' => $productivity,
                    'total' => $total,


                ]);

            }

            activity()
//                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('worker time sheet added for date ' . $request->date);
            DB::commit();
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

    public function index(Request $request)
    {
        //

        $model = new WorkerTimeSheet();
        $projects = auth()->user()->projects->pluck('id')->toArray();
        $rows = Worker::latest()->where('working_status', 'work')->whereIn('project_id', $projects);
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
        if ($request->filled('date')) {
            $date = $request->date;
        } else {
            $date = Carbon::today();
        }
        $rows->whereDoesntHave('workerTimeSheet', function ($q) use ($date) {
            $q->where('date', $date);

        });


        $rows = $rows->get();

        return view('admin.worker_time_sheet.index', compact('rows', 'model'));
    }

    public function workerTimeSheetHistory(Request $request)
    {
        $model = new WorkerTimeSheet();
        //
        $projects = auth()->user()->projects->pluck('id')->toArray();
//        $rows = WorkerTimeSheet::join('workers','worker_time_sheets.worker_id','=','workers.id')
        $rows = WorkerTimeSheet::orderBy('date','desc')->with('worker')
        ->select('worker_time_sheets.*')
        ->leftJoin('workers','worker_time_sheets.worker_id','=','workers.id')
            ->orderBy('workers.job_id')->latest('worker_time_sheets.created_at')
            ->whereHas('worker', function ($q) use ($request, $projects) {
                $q->whereIn('project_id', $projects);
        });
        if ($request->filled('project_id')) {
            $rows->whereHas('worker', function ($q) use ($request) {
                $q->where('project_id', $request->project_id);

            });
        }

        if ($request->filled('job_id')) {
            $rows->whereHas('worker', function ($q) use ($request) {
                $q->where('job_id', $request->job_id);

            });
        }

        if ($request->filled('organization_id')) {
            $rows->whereHas('worker', function ($q) use ($request) {
                $q->where('organization_id', $request->organization_id);

            });
        }

        if ($request->filled('department_id')) {
            $rows->whereHas('worker', function ($q) use ($request) {
                $q->where('department_id', $request->department_id);

            });
        }
        if ($request->filled('labors_group_id')) {
            $rows->whereHas('worker', function ($q) use ($request) {
                $q->where('labors_group_id', $request->labors_group_id);

            });
        }
//        if ($request->filled('job_id')) {
//            $rows->whereHas('worker', function ($q) use ($request) {
//                $q->where('job_id', $request->job_id);
//
//            });
//        }
        if ($request->filled('worker_id')) {
            $rows->where('worker_id', $request->worker_id);
        }

        if ($request->filled('from')) {
            $rows->where('date', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $rows->where('date', '<=', $request->to);
        }

        $rows = $rows->paginate(100);

        return view('admin.worker_time_sheet.history', compact('rows','model','request'));
    }

    public function exportExcel(Request $request){
        $response =  Excel::download(new WorkerTimeSheetHistoryExport($request), 'worker_time_sheet_history.xlsx');
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
        //
//        return $items = json_decode($request->items);
//        return $request->all();
        $rules = [

            'date' => 'required|date|date_format:Y-m-d',
            'attendance' => 'required|in:yes,no',
//            'overtime' => 'numeric|min:0',
//            'deduction_hrs' => 'numeric|min:0',
//            'safety' => 'numeric|min:0',


        ];


        $validator = validator()->make($request->all(), $rules);

        $validator->after(function ($validator) use ($request) {
            if ($request->ids) {

                if (count($request->ids) < 1) {

                    $validator->errors()->add('ids', trans('main.please_add_worker'));
                }
            } else {
                $validator->errors()->add('ids', trans('main.please_add_worker'));

            }
////          return  $request->items;
//            if (count(json_decode($request->items)) < 1) {
////            if (count(array_filter($request->items)) < 1) {
//
//                $validator->errors()->add('items', trans('main.please_add_item'));
//            }
        });
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();


        }
        DB::beginTransaction();
        try {

            foreach ($request->ids as $id) {
                $worker = Worker::find($id);
                if (!$worker) {
                    DB::rollBack();


                    return back()->withErrors(trans('main.server_error'))->withInput();
                }
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
                if ($request->attendance == "yes") {

                    $additions = ($request->overtime+$request->additional_overtime) * $hourly_salary;
                    $discounts = (($request->deduction_hrs + $request->safety) * $hourly_salary) + $request->deduction_value;
                    $total = $daily_salary + $additions - $discounts;
                } else {
                    $overtime = null;
                    $deduction_hrs = null;
                    $deduction_value = null;
                    $safety = null;
                    $additions = ($request->overtime+$request->additional_overtime) * $hourly_salary;
                    $discounts = (($request->deduction_hrs + $request->safety) * $hourly_salary) + $request->deduction_value;
                    $total = $additions - $discounts;
                }

                $row = WorkerTimeSheet::create([

                    'date' => $request->date,

                    'worker_id' => $id,
                    'hourly_salary' => $hourly_salary,
                    'daily_salary' => $daily_salary,
                    'attendance' => $request->attendance,
                    'overtime' => $request->overtime,
                    'additional_overtime'=>$request->additional_overtime,
                    'deduction_hrs' => $request->deduction_hrs,
                    'deduction_value' => $request->deduction_value,
                    'safety' => $request->safety,
                    'details' => $request->details,
                    'additions' => $additions,
                    'discounts' => $discounts,
                    'total' => $total,


                ]);

            }

            activity()
//                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('worker time sheet added for date ' . $request->date);
            DB::commit();
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
        $model = WorkerTimeSheet::findOrFail($id);
        return view('admin.worker_time_sheet.edit', compact('model'));
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


            'attendance' => 'required|in:yes,no',
//            'overtime' => 'numeric|min:0',
//            'deduction_hrs' => 'numeric|min:0',
//            'safety' => 'numeric|min:0',


        ];


        $validator = validator()->make($request->all(), $rules);

        $validator->after(function ($validator) use ($request) {

        });
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();


        }
        DB::beginTransaction();
        try {
            $row = WorkerTimeSheet::find($id);
            if ($request->attendance == "yes") {
//                dd( $request->all());
                $additions = ($request->overtime + $request->additional_overtime) * $row->hourly_salary;
                $discounts = (($request->deduction_hrs + $request->safety) * $row->hourly_salary) + $request->deduction_value;
                $total = $row->daily_salary + $additions - $discounts;
            } else {
//                dd(2);
                $overtime = null;
                $deduction_hrs = null;
                $deduction_value = null;
                $safety = null;
                $additions = ($request->overtime + $request->additional_overtime) * $row->hourly_salary;
                $discounts = (($request->deduction_hrs + $request->safety) * $row->hourly_salary) + $request->deduction_value;
                $total = $additions - $discounts;
            }
//dd($total_daily_minutes);
//            $total_daily_hrs = Carbon::parse("00:00:00")->addMinutes($total_daily_minutes);
//            dd($aa->format('H:i:s'));   foreach ($request->ids as $id) {


            $row->update([


                'attendance' => $request->attendance,
                'overtime' => $request->overtime,
                'additional_overtime'=>$request->additional_overtime,
                'deduction_hrs' => $request->deduction_hrs,
                'deduction_value' => $request->deduction_value,
                'safety' => $request->safety,
                'details' => $request->details,
                'additions' => $additions,
                'discounts' => $discounts,
                'total' => $total,
            ]);

            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('worker time sheet  :subject.id updated ');
            DB::commit();
//            return 1;
            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/worker-time-sheet-history');


        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage())->withInput();
//            return back();


        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();


            return back()->withErrors($ex->errorInfo[2])->withInput();

        }
    }

    public function updateAll(Request $request){
        $rules = [

//            'date' => 'required|date|date_format:Y-m-d',


            'attendance' => 'required|in:yes,no',
//            'overtime' => 'numeric|min:0',
//            'deduction_hrs' => 'numeric|min:0',
//            'safety' => 'numeric|min:0',


        ];


        $validator = validator()->make($request->all(), $rules);

        $validator->after(function ($validator) use ($request) {

        });
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();


        }
        DB::beginTransaction();
        try {
            foreach ($request->ids as $id) {
                $row = WorkerTimeSheet::find($id);
                if ($request->attendance == "yes") {
//                dd( $request->all());
                    $additions = $request->overtime * $row->hourly_salary;
                    $discounts = (($request->deduction_hrs + $request->safety) * $row->hourly_salary) + $request->deduction_value;
                    $total = $row->daily_salary + $additions - $discounts;
                } else {
//                dd(2);
                    $overtime = null;
                    $deduction_hrs = null;
                    $deduction_value = null;
                    $safety = null;
                    $additions = $request->overtime * $row->hourly_salary;
                    $discounts = (($request->deduction_hrs + $request->safety) * $row->hourly_salary) + $request->deduction_value;
                    $total = $additions - $discounts;
                }
//dd($total_daily_minutes);
//            $total_daily_hrs = Carbon::parse("00:00:00")->addMinutes($total_daily_minutes);
//            dd($aa->format('H:i:s'));   foreach ($request->ids as $id) {


                $row->update([


                    'attendance' => $request->attendance,
                    'overtime' => $request->overtime,
                    'deduction_hrs' => $request->deduction_hrs,
                    'deduction_value' => $request->deduction_value,
                    'safety' => $request->safety,
                    'details' => $request->details,
                    'additions' => $additions,
                    'discounts' => $discounts,
                    'total' => $total,
                ]);

                activity()
                    ->performedOn($row)
                    ->causedBy(auth()->user())
                    ->log('worker time sheet  :subject.id updated ');
            }
            DB::commit();
//            return 1;
            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/worker-time-sheet-history');


        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage())->withInput();
//            return back();


        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();


            return back()->withErrors($ex->errorInfo[2])->withInput();

        }
    }

    public function show($id)
    {
//        return "asa";
        $row = Extract::find($id);
        return view('admin.extract.show', compact('row'));
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

        $row = WorkerTimeSheet::findOrFail($id);



        if ($row->accounting_id != null) {
            toastr()->error(trans('main.u_cant_delete'));
            return back();
        }

        $row->delete();
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The worker time sheet :subject.id deleted');
        toastr()->success(trans('main.delete_done_successfully'));
        return back();

    }

    public function destroyGET($id)
    {
        $row = WorkerTimeSheet::findOrFail($id);

        if ($row->accounting_id != null) {
            toastr()->error(trans('main.u_cant_delete'));
            return back();
        }

        $row->delete();
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The worker time sheet :subject.id deleted');
        toastr()->success(trans('main.delete_done_successfully'));
        return back();
    }
}
