<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class LaborsGroup extends Model
{
    //

//    use LogsActivity;
    protected $table = 'labors_groups';


    public $timestamps = true;

    protected $guarded = ['id'];


}
