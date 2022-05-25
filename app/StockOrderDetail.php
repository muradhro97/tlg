<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockOrderDetail extends Model
{
    //


    protected $table = 'stock_order_details';


    public $timestamps = true;

    protected $guarded = ['id'];
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    public function stock_order(){
        return $this->belongsTo(StockOrder::class, 'stock_order_id');
    }

}
