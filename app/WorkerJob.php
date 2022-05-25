<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class WorkerJob extends Model
{

    public function newQuery()
    {
        return parent::newQuery()->where('type', 'worker');
    }

    protected $table = 'jobs';

    public $timestamps = true;

    protected $guarded = ['id'];

}
