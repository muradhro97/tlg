<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkerImage extends Model
{
    //
    protected $table = 'worker_images';


    public $timestamps = true;

    protected $guarded = ['id'];
}
