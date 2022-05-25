<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class ContractType extends Model
{
    //

//    use LogsActivity;
    protected $table = 'contract_types';


    public $timestamps = true;

    protected $guarded = ['id'];


}
