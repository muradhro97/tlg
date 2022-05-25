<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class Organization extends Model
{
    //

//    use LogsActivity;
    protected $table = 'organizations';


    public $timestamps = true;

    protected $guarded = ['id'];

    protected $appends = ['code'];

    public function getCodeAttribute(){
        $types = [
            'subContractor' =>  'sub',
            'owner' => 'own',
            'supplier' => 'sup',
            'mainContractor' => 'main',
        ];

        return $types[$this->type] . $this->id;

    }

    public function subcontracts(){
        return $this->hasMany(SubContract::class );
    }

    public function contracts(){
        return $this->hasMany(Contract::class );
    }

    public function extracts(){
        return $this->hasMany(Extract::class);
    }

    public function cashOut(){
        return $this->hasMany(Payment::class)->where('type','cashout');
    }

    public function confirmedCashOut(){
        return $this->hasMany(Payment::class)->where('type','cashout')->where('payment_status','paid');
    }

    public function actualCashIn(){
        return $this->hasMany(Accounting::class)->where('type','cashin');
    }

    public function confirmendActualCashIn(){
        return $this->hasMany(Accounting::class)->where('type','cashin')->where('payment_status','confirmed');
    }

    public function expenses(){
        return $this->hasMany(Accounting::class)->where('type','expense');
    }

    public function confirmedExpenses(){
        return $this->hasMany(Accounting::class)->where('type','expense')->where('payment_status','confirmed');
    }

    public function actualCashOut(){
        return $this->hasMany(Accounting::class)->where('type','cashout');
    }

    public function confirmendActualCashOut(){
        return $this->hasMany(Accounting::class)->where('type','cashout')->where('payment_status','confirmed');
    }

    public function getCreditorAttribute(){
        if ($this->type == 'subContractor')
        {
            return $this->extracts()->sum('total');
        }
        else
        {
            return $this->confirmendActualCashIn()->sum('amount');
        }
    }
    public function getDebtorAttribute(){
        if ($this->type == 'subContractor')
        {
            return $this->confirmedCashOut()->sum('amount') + $this->confirmendActualCashOut()->sum('amount');
        }
        else
        {
            return $this->extracts()->sum('total');
        }
    }

    public function getTotalDebtorAttribute(){
        if ($this->debtor > $this->creditor)
        {
            return $this->debtor - $this->creditor;
        }
        return 0;
    }

    public function getTotalCreditorAttribute(){
        if ($this->creditor > $this->debtor)
        {
            return $this->creditor - $this->debtor;
        }
        return 0;
    }



}
