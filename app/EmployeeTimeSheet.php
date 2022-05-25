<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeTimeSheet extends Model
{
    //


    protected $table = 'employee_time_sheets';
    protected $appends = ['attendance_color'];

    public $timestamps = true;

    protected $guarded = ['id'];
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function getAttendanceColorAttribute(){
        switch ($this->attendance)
        {
            case 'normal_vacation':
            case 'official_vacation_yes':
            case 'official_vacation_no':
                return 'green';
            case 'casual_vacation':
                return 'yellow';
            case 'no':
                return 'red';
            default:
                return false;
        }
    }



}
