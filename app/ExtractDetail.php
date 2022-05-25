<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExtractDetail extends Model
{
    //


    protected $table = 'extract_details';


    public $timestamps = true;
    protected $appends = ['item_name'];

    protected $guarded = ['id'];
    public function item()
    {
        return $this->belongsTo(ExtractItem::class,'item_id');
    }

    public function getItemNameAttribute($value){
        return  $this->item->name_unit ;
    }

}
