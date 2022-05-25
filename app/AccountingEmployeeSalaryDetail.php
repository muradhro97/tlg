<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class AccountingEmployeeSalaryDetail extends Model
{
    //


    protected $table = 'accounting_employee_salary_details';


    public $timestamps = true;

    protected $guarded = ['id'];
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function accounting(){
        return $this->belongsTo(Accounting::class);
    }

}
