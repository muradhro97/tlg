<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExtractImage extends Model
{
    protected $table = 'extract_images';


    public $timestamps = true;

    protected $guarded = ['id'];
}
