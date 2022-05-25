<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContractDetail extends Model
{
    //


    protected $table = 'contract_details';

    protected $appends = ['item_name'];
    public $timestamps = true;
    protected $hidden = ['item'];
    protected $guarded = ['id'];
    public function item()
    {
        return $this->belongsTo(ExtractItem::class,'item_id');
    }

    public function getItemNameAttribute($value){
        return  $this->item->name_unit ;
    }
}
