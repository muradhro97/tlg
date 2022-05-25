<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class Safe extends Model
{
    //
//    use LogsActivity;

    protected $table = 'safes';


    public $timestamps = true;

    protected $guarded = ['id'];


}
