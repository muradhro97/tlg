<?php

namespace App\Imports;

use App\Country;
use App\Department;
use App\Job;
use App\LaborsDepartment;
use App\LaborsGroup;
use App\Organization;
use App\Project;
use App\Worker;
use App\WorkerClassification;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class WorkerImport implements ToModel, WithHeadingRow, WithMultipleSheets
{

    public function sheets(): array
    {
        return [
            0 => $this,
        ];
    }

    public function model(array $row)
    {
        $nationality_no = (string)$row['nationality_no'];
        $name = $row['name'];
//        dd($row);
//        dd( Carbon::parse('1900-01-01')->addDays( $row['start_date'])->format('Y-m-d'));
        if ($name and $nationality_no) {
            $check = Worker::where('nationality_no', $nationality_no)->OrWhere('name', $name)
                ->first();

            $job = Job::where('name', $row['job'])->first();

            $organization = Organization::where('name', $row['organization'])->first();
            $project = Project::where('name', $row['project'])->first();
            $nationality = Country::where('nationality', $row['nationality'])->first();
            $department = LaborsDepartment::where('name', $row['department'])->first();
            $labors_group = LaborsGroup::where('name', $row['labors_group'])->first();
            $worker_classification = WorkerClassification::where('name', $row['worker_classification'])->first();
//dd($row['department']);
//            if ($job) {

            $check2 = Worker::where('job_id', $job->id)->max('unique_no_helper') ?? 0;
//            } else {
//                dd($row);
//            }
//            $check= Worker::where('job_id',$row->job_id)->where('id','<',$row->id)->count();
            $no = $check2 + 1;
            $abbreviation = $job->abbreviation ?? 'error';
            $unique_no = $abbreviation . $no;
            $unique_no_helper = $no;

//        dd($job->id);
//        dd($row['job']);
//        $name = $row['name'];
//        dd($name);
            if (!$check) {
//                dd($check);
                return new Worker([
                    'name' => $row['name'],
                    'address' => $row['address'],
                    'nationality_no' => (string)$row['nationality_no'],
                    'social_status' => $row['social_status'],
                    'military_status' => $row['military_status'],
                    'gender' => $row['gender'],
                    'mobile' => (string)$row['mobile'],
                    'job_id' => $job->id ?? '',
                    'organization_id' => $organization->id ?? '',
                    'project_id' => $project->id ?? '',
                    'nationality_id' => $nationality->id ?? '',
                    'department_id' => $department->id ?? '',
                    'labors_group_id' => $labors_group->id ?? '',
                    'worker_classification_id' => $worker_classification->id ?? '',
                    'site_id' => (string)$row['site_id'],
                    'birth_date' => Carbon::parse($row['birth_date']),
                    'start_date' => Carbon::parse($row['start_date']),
                    'working_status' => $row['working_status'],
                    'unique_no' => $unique_no,
                    'unique_no_helper' => $unique_no_helper,

//                'type' => "worker",
                ]);
//            dd($aa);
            }

        }
    }
}
