<?php

namespace App\Imports;

use App\ApplicantWorker;
use App\Job;
use App\Organization;
use App\Project;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithValidation;

class ApplicantWorkerImport implements ToModel, WithHeadingRow, WithMultipleSheets
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function sheets(): array
    {
        return [
            0 => $this,
        ];
    }

    public function model(array $row)
    {
        $nationality_no = $row['nationality_no'];
//        dd($nationality_no);

        $check = ApplicantWorker::where('nationality_no', $nationality_no)->first();
        $job = Job::where('name', $row['job'])->first();
        $organization = Organization::where('name', $row['organization'])->first();
        $project = Project::where('name', $row['project'])->first();
//        dd($job->id);
//        dd($row['job']);
//        $name = $row['name'];
//        dd($name);
        if (!$check and $nationality_no) {

           return new ApplicantWorker([
                'name' =>$row['name'] ,
                'address' => $row['address'],
                'nationality_no' => (string)$row['nationality_no'],
                'social_status' => $row['social_status'],
                'military_status' => $row['military_status'],
                'gender' => $row['gender'],
                'mobile' =>  (string)$row['mobile'],
                'job_id' => $job->id ?? '',
                'organization_id' => $organization->id ?? '',
                'project_id' => $project->id ?? '',

                'type' => "worker",
            ]);
//            dd($aa);
        }

    }

}
