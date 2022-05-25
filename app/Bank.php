<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class Bank extends Model
{
    //

//    use LogsActivity;
    protected $table = 'banks';


    public $timestamps = true;

    protected $guarded = ['id'];


}
