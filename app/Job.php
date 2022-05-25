<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class Job extends Model
{
    protected $table = 'jobs';

    public $timestamps = true;

    protected $guarded = ['id'];

}
