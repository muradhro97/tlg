<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Accounting extends Model
{
    //


    protected $table = 'accounting';


    public $timestamps = true;

    protected $guarded = ['id'];

    public function scopeCashIn($query){
        return $query->where('type','cashin');
    }

    public function images()
    {
        return $this->hasMany(AccountingImage::class);
    }
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function safeTransaction(){
        return $this->hasOne(SafeTransaction::class);
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function safe()
    {
        return $this->belongsTo(Safe::class);
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function laborsDepartment()
    {
        return $this->belongsTo(LaborsDepartment::class);
    }

    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }
    public function accountingDetails()
    {
        return $this->hasMany(AccountingDetail::class,'accounting_id');
    }
    public function accountingWorkerSalaryDetail()
    {
        return $this->hasMany(AccountingWorkerSalaryDetail::class,'accounting_id');
    }
    public function accountingEmployeeSalaryDetail()
    {
        return $this->hasMany(AccountingEmployeeSalaryDetail::class,'accounting_id');
    }
    public function cacIinDetails(){
        return $this->hasMany(CashInDetail::class);
    }
}
