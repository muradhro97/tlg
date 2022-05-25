<?php

namespace App\Imports;

use App\Worker;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class WorkerImportold implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Worker([
            'name' => $row['name'],
            'nationality_no' => $row['nationality_no'],
            'social_status' => $row['social_status'],
            'military_status' => $row['military_status'],
        ]);
//        return new Worker([
//            'name'     => $row[0],
//            'nationality_no'    => $row[1],
//            'social_status' =>$row[2],
//            'military_status' =>$row[2],
//        ]);
    }
}
