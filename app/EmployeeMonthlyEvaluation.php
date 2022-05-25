<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image;

class EmployeeMonthlyEvaluation extends Model
{
    //
//    use LogsActivity;

    protected $table = 'employee_monthly_evaluations';


    public $timestamps = true;

    protected $guarded = ['id'];
    public function setImageAttribute($value)
    {
        if ($value) {
            $path='uploads/evaluations/';
            $path_thumb=$path .'thumb_';
            $this->deleteImage($this->image);
            $this->deleteImage($this->image_thumb);
//            $this->deleteImage( $this->license_image_thumb );
            $name = time() . '' . rand(11111, 99999) . '.' . $value->getClientOriginalExtension();

            $image = Image::make($value);
//            $image->widen(300, null);
            $image->save($path . $name);
            $image->widen( 100, null );
//            $image->resize(128, 128);
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
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

}
