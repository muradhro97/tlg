<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockOrder extends Model
{
    //

    protected $table = 'stock_orders';


    public $timestamps = true;

    protected $guarded = ['id'];
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function worker(){
        return $this->belongsTo(Worker::class);
    }
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function stockType()
    {
        return $this->belongsTo(StockType::class,'stock_type');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class,'approved_by');
    }
    public function stockDetails()
    {
        return $this->hasMany(StockOrderDetail::class,'stock_order_id');
    }
}
