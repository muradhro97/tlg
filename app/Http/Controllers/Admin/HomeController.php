<?php

namespace App\Http\Controllers\Admin;


use App\Contract;
use App\Employee;
use App\SubContract;
use App\Worker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Permission;


class HomeController extends Controller
{
    //
    public function index()
    {

//        $data = array(
//            'forget_code' => '123',
//            'name' => 'aaaa',
//        );
//        Mail::send('emails.password-code', ['data' => $data], function ($message)  {
//            $message->from('admin@skilzat.com', 'Skilzat');
//            $message->to('hatemgodaphp@gmail.com')
//                ->subject('كود استرجاع كلمة المرور');
//        });
//        return 123;

//        $mains = ['Department', 'LaborDepartment', 'LaborGroup', 'Category', 'Organization', 'Project', 'Unit', 'Bank', 'Country', 'State', 'City', 'EmployeeJob', 'WorkerJob', 'University'];
//        $mains = ['StockType','Item','ContractType'];
//        $subs = ['all', 'add', 'edit', 'delete'];
//        foreach ($mains as $m) {
//            foreach ($subs as $s) {
//                $permission = Permission::create(['name' => $s . $m]);
//            }
//        }


//        return "done";
        $worker_by_projects = Worker::Query()
            ->join('projects', 'projects.id', '=', 'workers.project_id')
            ->select('projects.name', 'project_id', DB::raw('count(*) as total'))
            ->groupBy('project_id')
            ->get();
        $worker_by_jobs = Worker::Query()
            ->join('jobs', 'jobs.id', '=', 'workers.job_id')
            ->select('jobs.name', 'job_id', DB::raw('count(*) as total'))
            ->groupBy('job_id')
            ->get();


        $today_worker_by_projects = Worker::Query()
            ->join('projects', 'projects.id', '=', 'workers.project_id')
            ->select('projects.name', 'project_id', DB::raw('count(*) as total'))
            ->groupBy('project_id')
            ->where('workers.created_at',today())
            ->get();
        $today_worker_by_jobs = Worker::Query()
            ->join('jobs', 'jobs.id', '=', 'workers.job_id')
            ->select('jobs.name', 'job_id', DB::raw('count(*) as total'))
            ->groupBy('job_id')
            ->where('workers.created_at',today())
            ->get();

        $employee_by_projects = Employee::Query()
            ->join('projects', 'projects.id', '=', 'employees.project_id')
            ->select('projects.name', 'project_id', DB::raw('count(*) as total'))
            ->groupBy('project_id')
            ->get();
        $employee_by_jobs = Employee::Query()
            ->join('jobs', 'jobs.id', '=', 'employees.job_id')
            ->select('jobs.name', 'job_id', DB::raw('count(*) as total'))
            ->groupBy('job_id')
            ->get();

        $contracts= Contract::count();
        $sub_contracts= SubContract::count();
//return $outdoors= Outdoor::select('name','lat','lon')->get()->toArray();
// $locations= Outdoor::select('name','lat','lon')->get()->toArray();

//return array_values($outdoors);
        return view('admin.index', compact('worker_by_projects', 'worker_by_jobs','employee_by_projects','employee_by_jobs','today_worker_by_projects','today_worker_by_jobs','contracts','sub_contracts'));
    }



}
