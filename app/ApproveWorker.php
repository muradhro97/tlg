<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image;

class ApproveWorker extends Model
{
    //


    protected $table = 'workers';


    public $timestamps = true;

    protected $guarded = ['id'];




}
