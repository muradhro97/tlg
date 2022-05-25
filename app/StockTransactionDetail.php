<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockTransactionDetail extends Model
{
    //


    protected $table = 'stock_transaction_details';


    public $timestamps = true;

    protected $guarded = ['id'];


}
