<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class City extends Model
{
    //

//    use LogsActivity;


    protected $table = 'cities';


    public $timestamps = true;

    protected $guarded = ['id'];
    public function state()
    {

        return $this->belongsTo(State::class);
    }

}
