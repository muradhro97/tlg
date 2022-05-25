<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image;
use Spatie\Activitylog\Traits\LogsActivity;
class Setting extends Model
{
//    use LogsActivity;
    protected $table = 'settings';
    public $timestamps = true;
    protected $guarded = ['id'];

    public function setImageAttribute($value)
    {
        if ($value) {
            $this->deleteImage($this->image);
            $name = time() . '' . rand(11111, 99999) . '.' . $value->getClientOriginalExtension();
            $image = Image::make($value);
            $image->widen(300, null);
//            $image->heighten(250, null);
            $image->save('uploads/settings/' . $name);
            $this->attributes['image'] = 'uploads/settings/' . $name;

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

}