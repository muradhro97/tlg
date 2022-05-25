<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class ExtractItem extends Model
{
    //
//    use LogsActivity;

    protected $table = 'extract_items';


    public $timestamps = true;

    protected $guarded = ['id'];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    protected $appends = ['name_unit'];
    public function getNameUnitAttribute($value){
        return $this->name .'|'.$this->unit->name ??'..';
//        return $this->name . $this->unit->name ??'..';
    }


}
