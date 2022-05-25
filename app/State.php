<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class State extends Model
{
    //

//    use LogsActivity;
    protected $table = 'states';


    public $timestamps = true;

    protected $guarded = ['id'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
