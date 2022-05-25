<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $table = 'sizes';


    public $timestamps = true;

    protected $guarded = ['id'];

    public function items(){
        return $this->belongsToMany(Item::class);
    }
}
