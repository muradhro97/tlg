<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item_quantity extends Model
{
    protected $table = 'item_quantities';
    public $timestamps = true;

    protected $guarded = ['id'];

    public function color(){
        return $this->belongsTo(Color::class);
    }
    public function size(){
        return $this->belongsTo(Size::class);
    }
    public function item(){
        return $this->belongsTo(Item::class);
    }
}

