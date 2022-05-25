<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image;
use Spatie\Activitylog\Traits\LogsActivity;
class ApplicantEmployee extends Model
{
    //
//    use LogsActivity;
    public function newQuery()
    {
        return parent::newQuery()->where('type', 'employee');
    }


    protected $table = 'applicants';


    public $timestamps = true;

    protected $guarded = ['id'];

    public function setImageAttribute($value)
    {
        if ($value) {
            $path='uploads/applicants/';
            $path_thumb=$path .'thumb_';
            $this->deleteImage($this->image);
            $this->deleteImage($this->image_thumb);
//            $this->deleteImage( $this->license_image_thumb );
            $name = time() . '' . rand(11111, 99999) . '.' . $value->getClientOriginalExtension();

            $image = Image::make($value);
//            $image->widen(300, null);
            $image->save($path . $name);
//            $image->widen( 100, null );
            $image->resize(128, 128);
            $image->save($path_thumb . $name );
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

    public function images()
    {
        return $this->hasMany(ApplicantImage::class,'applicant_id');
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
        return $this->belongsTo(Country::class,'nationality_id');
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }


    public function getGenderDisplayAttribute($value)
    {
        if($this->gender) {
            $genderOptions = [


                'male' => trans('main.male'),
                'female' => trans('main.female'),

            ];
            return $genderOptions[$this->gender];
        }
        return '';

    }

    public function getEvaluationStatusDisplayAttribute($value)
    {
        if($this->evaluation_status) {
            $genderOptions = [


                'wait' => trans('main.wait'),
                'delay' => trans('main.delay'),
                'reject' => trans('main.reject'),
                'accept' => trans('main.accept'),
                'approve' => trans('main.approve'),

            ];
            return $genderOptions[$this->evaluation_status];
        }
        return '';

    }
    public function getAgeAttribute($value)
    {
        if($this->birth_date){
            return Carbon::createFromFormat('Y-m-d', $this->birth_date)
                    ->diff(new Carbon('now'))
                    ->y .' '. trans('main.year_old');
        }
     return '';
//        $genderOptions = [
//
//
//            'male' => trans('main.male'),
//            'female' => trans('main.female'),
//
//        ];
//        return $genderOptions[$this->gender];

    }
    public function getWorkingStatusDisplayAttribute($value)
    {
        if($this->working_status) {
            $workingStatusOptions = [


                'work' => trans('main.work'),
                'fired' => trans('main.fired'),
                'resigned' => trans('main.resigned'),
//            'retired' => trans('main.retired'),

            ];
            return $workingStatusOptions[$this->working_status];
        }
        return '';
    }


}
