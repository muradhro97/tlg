<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class BankAccount extends Model
{
    //
//    use LogsActivity;
    public function newQuery()
    {
        return parent::newQuery()->where('type', 'BankAccount');
    }

    protected $table = 'safes';


    public $timestamps = true;

    protected $guarded = ['id'];


}
