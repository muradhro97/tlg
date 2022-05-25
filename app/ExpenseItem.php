<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class ExpenseItem extends Model
{


//    use LogsActivity;
    protected $table = 'expense_items';


    public $timestamps = true;

    protected $guarded = ['id'];


}
