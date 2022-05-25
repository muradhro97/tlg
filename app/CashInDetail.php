<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CashInDetail extends Model
{
    protected $table = 'cash_in_details';


    public $timestamps = true;

    protected $guarded = ['id'];
    public function item()
    {
        return $this->belongsTo(ExtractItem::class,'item_id');
    }

    public function getItemNameAttribute($value){
        return  $this->item->name_unit ;
    }
}
