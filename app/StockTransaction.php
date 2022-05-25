<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockTransaction extends Model
{
    //


    protected $table = 'stock_transactions';


    public $timestamps = true;

    protected $guarded = ['id'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
