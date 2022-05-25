<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class Item extends Model
{
    //

//    use LogsActivity;
    protected $table = 'items';


    public $timestamps = true;

    protected $guarded = ['id'];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

//    protected $appends = ['name_unit'];
    public function getNameUnitAttribute($value){
        return $this->name .'|'.$this->unit->name ??'..';
    }

    public function colors(){
        return $this->belongsToMany(Color::class);
    }

    public function sizes(){
        return $this->belongsToMany(Size::class);
    }

    public function item_quantities(){
        return $this->hasMany(Item_quantity::class)->where('is_priced',0);
    }

    public function all_item_quantities(){
        return $this->hasMany(Item_quantity::class);
    }

    public function stock_order_details(){
        return $this->hasMany(StockOrderDetail::class);
    }

}
