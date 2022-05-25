<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class Penalty extends Model
{
    //

//    use LogsActivity;
    protected $table = 'penalties';


    public $timestamps = true;

    protected $guarded = ['id'];
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

}
