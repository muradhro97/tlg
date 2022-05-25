<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee_change_log extends Model
{
    public $timestamps = true;

    protected $guarded = ['id'];

    protected $table = 'employee_change_logs';


    public function employee(){
        return $this->belongsTo(Employee::class);
    }
}
