<?php

namespace App\Exports;

use App\Accounting;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class WorkerSalariesExport implements FromView
{
    public function view(): View
    {
        return view('admin.worker_salary.excel_table', [
            'rows' => Accounting::all()
        ]);
    }
}
