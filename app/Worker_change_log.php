<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Worker_change_log extends Model
{
    public $timestamps = true;

    protected $guarded = ['id'];

    protected $table = 'worker_change_logs';

    public function worker(){
        return $this->belongsTo(Worker::class);
    }
}
