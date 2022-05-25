<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image;
use Spatie\Activitylog\Traits\LogsActivity;
class ApplicantWorker extends Model
{
    //
//    use LogsActivity;
    public function newQuery()
    {
        return parent::newQuery()->where('type', 'worker');
    }


    protected $table = 'applicants';


    public $timestamps = true;

    protected $guarded = ['id'];

    public function setImageAttribute($value)
    {
        if ($value) {
            $path = 'uploads/applicants/';
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
        return $this->hasMany(ApplicantImage::class, 'applicant_id');
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
        return $this->belongsTo(LaborsDepartment::class, 'department_id');
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
        return '';
    }

    public function getTechnicalDisplayAttribute($value)
    {

        if ($this->technical) {
            $technicalOptions = [
                'expert' => trans('main.expert'),
                'professional' => trans('main.professional'),
                'good' => trans('main.good'),
                'low' => trans('main.low'),
                'no_experience' => trans('main.no_experience'),
            ];
            return $technicalOptions[$this->technical];
        }
        return '';

    }

    public function getMedicalDisplayAttribute($value)
    {

        if ($this->medical) {
            $medicalOptions = [
                'normal' => trans('main.normal'),
                'upnormal' => trans('main.upnormal'),


            ];
            return $medicalOptions[$this->medical];


        }
        return '';
    }

    public function getWeightDisplayAttribute($value)
    {

        if ($this->weight) {
            $weightOptions = [
                'weak' => trans('main.weak'),
                'fit' => trans('main.fit'),
                'over_weight' => trans('main.over_weight'),

            ];

            return $weightOptions[$this->weight];

        }
        return '';
    }

    public function getMentalityDisplayAttribute($value)
    {

        if ($this->mentality) {
            $mentalityOptions = [
                'normal' => trans('main.normal'),
                'chronic' => trans('main.chronic'),
                'disease' => trans('main.disease'),
                'ostensible' => trans('main.ostensible'),

            ];

            return $mentalityOptions[$this->mentality];

        }
        return '';
    }


}
