<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountingImage extends Model
{
    //
    protected $table = 'accounting_images';


    public $timestamps = true;

    protected $guarded = ['id'];
}
