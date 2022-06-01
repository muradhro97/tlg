<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class Project extends Model
{
    //

//    use LogsActivity;
    protected $table = 'projects';


    public $timestamps = true;

    protected $guarded = ['id'];

    public function employeeTimeSheets(){
        return $this->hasManyThrough(EmployeeTimeSheet::class,Employee::class);
    }

    public function workerTimeSheets(){
        return $this->hasManyThrough(WorkerTimeSheet::class,Worker::class);
    }

}
