<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class Contract extends Model
{

//    use LogsActivity;
    public function newQuery()
    {
        return parent::newQuery()->where('type', 'main');
    }

    protected $table = 'contracts';


    public $timestamps = true;

    protected $guarded = ['id'];

    public function items()
    {
        return $this->hasMany(ContractDetail::class);
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

    public function files(){
        return $this->hasMany(Contract_file::class);
    }
}
