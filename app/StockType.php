<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class StockType extends Model
{
    //
//    use LogsActivity;

    protected $table = 'stock_types';


    public $timestamps = true;

    protected $guarded = ['id'];


}
