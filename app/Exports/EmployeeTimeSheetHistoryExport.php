<?php

namespace App\Exports;

use App\EmployeeTimeSheet;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EmployeeTimeSheetHistoryExport implements FromView
{
    public $request ;
    function __construct($request) {
        $this->request = $request;
    }
    public function view(): View
    {
        $request = $this->request;
        $model = new EmployeeTimeSheet();

        $projects = auth()->user()->projects->pluck('id')->toArray();
        $rows = EmployeeTimeSheet::latest()
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
        if ($request->filled('employee_id')) {
            $rows->where('employee_id', $request->employee_id);
        }
        if ($request->filled('from')) {
            $rows->where('date', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $rows->where('date', '<=', $request->to);
        }
        $rows = $rows->get();

        return view('admin.employee_time_sheet.excel_table', [
            'rows' => $rows
        ]);
    }
}
