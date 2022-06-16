<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class Payment extends Model
{
    //

//    use LogsActivity;
    protected $table = 'payments';


    public $timestamps = true;

    protected $guarded = ['id'];

    public function images()
    {
        return $this->hasMany(PaymentImage::class);
    }
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function safe_transaction(){
        return $this->belongsTo(SafeTransaction::class,'id','payment_id');
    }
}
