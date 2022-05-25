<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentImage extends Model
{
    //
    protected $table = 'payment_images';


    public $timestamps = true;

    protected $guarded = ['id'];
}
