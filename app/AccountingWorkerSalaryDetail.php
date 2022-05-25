<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class AccountingWorkerSalaryDetail extends Model
{
    //


    protected $table = 'accounting_worker_salary_details';


    public $timestamps = true;

    protected $guarded = ['id'];
    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }

    public function accounting(){
        return $this->belongsTo(Accounting::class);
    }

}
