<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContractItem extends Model
{
    //


    protected $table = 'contract_items';


    public $timestamps = true;

    protected $guarded = ['id'];

}
