<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class Unit extends Model
{
    //
//    use LogsActivity;

    protected $table = 'units';


    public $timestamps = true;

    protected $guarded = ['id'];


}
