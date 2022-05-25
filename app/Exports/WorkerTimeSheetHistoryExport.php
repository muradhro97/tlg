<?php

namespace App\Exports;


use App\WorkerTimeSheet;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class WorkerTimeSheetHistoryExport implements FromView
{
    public $request ;
    function __construct($request) {
        $this->request = $request;
    }
    public function view(): View
    {
        $request = $this->request;
        $model = new WorkerTimeSheet();

        $projects = auth()->user()->projects->pluck('id')->toArray();
        $rows = WorkerTimeSheet::join('workers','worker_time_sheets.worker_id','=','workers.id')->orderBy('workers.job_id')->latest('worker_time_sheets.created_at')
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

        if ($request->filled('worker_id')) {
            $rows->where('worker_id', $request->worker_id);
        }

        if ($request->filled('from')) {
            $rows->where('date', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $rows->where('date', '<=', $request->to);
        }


        $rows = $rows->get();
        return view('admin.worker_time_sheet.excel_table', [
            'rows' => $rows
        ]);
    }
}
