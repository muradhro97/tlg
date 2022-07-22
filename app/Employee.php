<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image;
use Spatie\Activitylog\Traits\LogsActivity;

class Employee extends Model
{

    protected $table = 'employees';


    public $timestamps = true;

    protected $guarded = ['id'];

    public function setImageAttribute($value)
    {
        if ($value) {
            $path = 'uploads/employees/';
            $path_thumb = $path . 'thumb_';
            $this->deleteImage($this->image);
            $this->deleteImage($this->image_thumb);
//            $this->deleteImage( $this->license_image_thumb );
            $name = time() . '' . rand(11111, 99999) . '.' . $value->getClientOriginalExtension();

            $image = Image::make($value);
//            $image->widen(300, null);
            $image->save($path . $name);
//            $image->widen( 100, null );
            $image->resize(128, 128);
            $image->save($path_thumb . $name);
            $this->attributes['image'] = $path . $name;
            $this->attributes['image_thumb'] = $path_thumb . $name;

        }
    }

    public function deleteImage($name)
    {
        $deletepath = base_path($name);
        if (file_exists($deletepath) and $name != '') {
            unlink($deletepath);
        }

        return true;
    }

    public function timeSheet()
    {
        return $this->hasMany(EmployeeTimeSheet::class, 'employee_id');
    }

    public function images()
    {
        return $this->hasMany(EmployeeImage::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'nationality_id');
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function university()
    {
        return $this->belongsTo(University::class);
    }

    public function getGenderDisplayAttribute($value)
    {
        if ($this->gender) {
            $genderOptions = [
                'male' => trans('main.male'),
                'female' => trans('main.female'),

            ];
            return $genderOptions[$this->gender];
        }
        return "";

    }

    public function getWorkingStatusDisplayAttribute($value)
    {
        if ($this->working_status) {
            $workingStatusOptions = [


                'work' => trans('main.work'),
                'fired' => trans('main.fired'),
                'resigned' => trans('main.resigned'),
                'retired' => trans('main.retired'),
                'not_started' => trans('main.not_started'),

            ];
            return $workingStatusOptions[$this->working_status];
        }
        return "";

    }

    public function employeeTimeSheet()
    {
        return $this->hasMany(EmployeeTimeSheet::class);
    }

    public function scopeEmployeeTimeSheetInDuration($query, $from, $to)
    {
        return $query->whereHas('employeeTimeSheet', function ($q) use ($from, $to) {
            $q->whereBetween('date', [$from, $to])->whereNull('accounting_id');

        });
    }

    public function loans()
    {
        return $this->hasMany(Accounting::class)->where('type', 'employeeLoan')->where('payment_status', 'confirmed');
    }

    public function employeeMonthlyEvaluation()
    {
        return $this->hasMany(EmployeeMonthlyEvaluation::class);
    }

    public function penalty()
    {
        return $this->hasMany(Penalty::class);
    }

    public function change_logs(){
        return $this->hasMany(Employee_change_log::class);
    }

    public function custody(){
        return $this->hasMany(Payment::class)->where('type', 'custody');
    }

    public function custodyRest(){
        return $this->hasMany(Payment::class)->where('type', 'custodyRest');
    }

    public function invoices(){
        return $this->hasMany(Accounting::class);
    }

    public function custodyInvoices(){
        return $this->hasMany(Accounting::class)->where('is_on_custody',1);
    }

    public function employee_salary_details(){
        return $this->hasMany(AccountingEmployeeSalaryDetail::class);
    }
}
