<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class University extends Model
{
    //
//    use LogsActivity;

    protected $table = 'universities';


    public $timestamps = true;

    protected $guarded = ['id'];


}
