<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SafeTransaction extends Model
{
    //


    protected $table = 'safe_transactions';


    public $timestamps = true;

    protected $guarded = ['id'];

    public function parent()
    {
        if ($this->payment_id != null) {
            return $this->belongsTo(Payment::class,'payment_id');
        } elseif ($this->accounting_id != null) {
            return $this->belongsTo(Accounting::class,'accounting_id');
        }
        // murad
        return $this->belongsTo(Accounting::class,'accounting_id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function accounting()
    {
        return $this->belongsTo(Accounting::class);
    }

    public function safe()
    {
        return $this->belongsTo(Safe::class);
    }

}
