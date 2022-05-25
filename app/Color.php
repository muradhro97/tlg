<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $table = 'colors';

    public $timestamps = true;

    protected $guarded = ['id'];

    public function items(){
        return $this->belongsToMany(Item::class);
    }

}
