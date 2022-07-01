<?php

namespace App\Http\Eloquent;

use App\Http\Interfaces\WorkerTimeSheetRepositoryInterface;
use App\Worker;
use App\WorkerTimeSheet;
use Illuminate\Support\Facades\DB;

class WorkerTimeSheetRepository implements WorkerTimeSheetRepositoryInterface
{
    protected $model;

    public  function __construct(WorkerTimeSheet $model)
    {
        $this->model = $model;
    }

    public function history($request,$projects)
    {
        return $this->model->orderBy('date','desc')->with('worker')
            ->select('worker_time_sheets.*')
            ->leftJoin('workers','worker_time_sheets.worker_id','=','workers.id')
            ->orderBy('workers.job_id')->latest('worker_time_sheets.created_at')
            ->whereHas('worker', function ($q) use ($request, $projects) {
                $q->whereIn('project_id', $projects);
        });
    }

    public function updateDaily($request,$id){
        DB::beginTransaction();
        try {
            $row = $this->model::find($id);
            if ($request->attendance == "yes") {
                $additions = ($request->overtime + $request->additional_overtime) * $row->hourly_salary;
                $discounts = (($request->deduction_hrs + $request->safety) * $row->hourly_salary) + $request->deduction_value;
                $total = $row->daily_salary + $additions - $discounts;
            } else {
                $additions = ($request->overtime + $request->additional_overtime) * $row->hourly_salary;
                $discounts = (($request->deduction_hrs + $request->safety) * $row->hourly_salary) + $request->deduction_value;
                $total = $additions - $discounts;
            }

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

            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/worker-time-sheet-history');


        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function updateProductivity($request,$id){
        DB::beginTransaction();
        try {
            $row = $this->model::find($id);

            $worker = $row->worker;
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


            $row->update([
                'attendance' => $request->attendance,
                'details' => $request->details,
                'unit_price' => $unit_price,
                'productivity' => $productivity,
                'total' => $total,
            ]);



            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('worker time sheet  :subject.id updated ');
            DB::commit();

            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/worker-time-sheet-history');


        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }

    }
}
