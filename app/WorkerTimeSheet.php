<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkerTimeSheet extends Model
{
    //


    protected $table = 'worker_time_sheets';

    public $timestamps = true;

    protected $guarded = ['id'];

    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }





}
