<?php

namespace App\Exports;


use App\Employee;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EmployeeExport implements FromView
{
    public $request ;
    function __construct($request) {
        $this->request = $request;
    }
    public function view(): View
    {
        $request = $this->request;
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

        return view('admin.employee.excel_table', [
            'rows' => $rows->get()
        ]);
    }
}
