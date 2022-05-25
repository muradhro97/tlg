<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class Department extends Model
{
    //

//    use LogsActivity;
    protected $table = 'departments';


    public $timestamps = true;

    protected $guarded = ['id'];


}
