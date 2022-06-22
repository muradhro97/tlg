<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class SubContract extends Model
{
    //
//    use LogsActivity;
    public function newQuery()
    {
        return parent::newQuery()->where('type', 'sub');
    }


    protected $table = 'contracts';


    public $timestamps = true;

    protected $guarded = ['id'];

    public function items()
    {
        return $this->hasMany(ContractDetail::class,'contract_id');
    }

    public function extract_items(){
        return $this->hasManyThrough(ExtractItem::class,ContractDetail::class,'contract_id','id','id','item_id');
    }

    public function contractType()
    {
        return $this->belongsTo(ContractType::class,'type_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
    public function extracts()
    {
        return $this->hasMany(Extract::class);
    }
    public function files(){
        return $this->hasMany(Contract_file::class,'contract_id');
    }

}
