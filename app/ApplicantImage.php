<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicantImage extends Model
{
    //
    protected $table = 'applicant_images';


    public $timestamps = true;

    protected $guarded = ['id'];
}
