<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class LaborsDepartment extends Model
{
    //

//    use LogsActivity;
    protected $table = 'labors_departments';


    public $timestamps = true;

    protected $guarded = ['id'];


}
