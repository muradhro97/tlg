<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class EmployeeJob extends Model
{
    //
//    use LogsActivity;
    public function newQuery()
    {
        return parent::newQuery()->where('type', 'employee');
    }

    protected $table = 'jobs';


    public $timestamps = true;

    protected $guarded = ['id'];


}
