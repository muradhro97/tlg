<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class Extract extends Model
{
    //

//    use LogsActivity;
    protected $table = 'extracts';


    public $timestamps = true;

    protected $guarded = ['id'];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
    public function subContract()
    {
        return $this->belongsTo(SubContract::class);
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }


    public function items()
    {
        return $this->hasMany(ExtractDetail::class);
    }

    public function plus_items()
    {
        return $this->hasMany(ExtractDetail::class)->where('price','>=',0);
    }
    public function minus_items()
    {
        return $this->hasMany(ExtractDetail::class)->where('price','<',0);
    }
    public function images(){
        return $this->hasMany(ExtractImage::class);
    }

//    public function contractType()
//    {
////        return $this->belongsTo(ContractType::class,'type_id');
//        return $this->hasOneThrough(ContractType::class, SubContract::class,'type_id');
//    }


}
