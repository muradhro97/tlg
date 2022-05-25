<?php

namespace App\Exports;

use App\Worker;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class WorkersExport implements FromView
{
    public $request ;
    function __construct($request) {
        $this->request = $request;
    }
    public function view(): View
    {
        $request = $this->request;
        $rows = Worker::latest();//            ->orWhereNull('project_id')
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
        return view('admin.worker.excel_table', [
            'rows' => $rows->get()
        ]);
    }
}
