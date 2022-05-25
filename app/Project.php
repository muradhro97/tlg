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


}
