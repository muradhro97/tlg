<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class WorkerClassification extends Model
{


//    use LogsActivity;
    protected $table = 'worker_classifications';


    public $timestamps = true;

    protected $guarded = ['id'];


}
