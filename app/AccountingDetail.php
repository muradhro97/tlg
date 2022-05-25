<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountingDetail extends Model
{
    //


    protected $table = 'accounting_details';


    public $timestamps = true;

    protected $guarded = ['id'];
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    public function expenseItem()
    {
        return $this->belongsTo(ExpenseItem::class,'item_id');
    }
    public function accounting(){
        return $this->belongsTo(Accounting::class);
    }

}
