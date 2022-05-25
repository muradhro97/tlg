<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class Category extends Model
{
    //

//    use LogsActivity;
    protected $table = 'categories';


    public $timestamps = true;

    protected $guarded = ['id'];

    public function main()
    {
        return $this->belongsTo(self::class, 'main_category', 'id');
    }

    public function getMainDisplayAttribute($value)
    {
      if($this->main){
        return $this->main->name  ;
      }
      return trans('main.main_category');
    }
}
