<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image;

class ApproveEmployee extends Model
{
    //


    protected $table = 'employees';


    public $timestamps = true;

    protected $guarded = ['id'];




}
