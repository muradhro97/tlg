@include('partials.validation-errors')


@inject('employee','App\Employee')
@inject('safe','App\Safe')

<?php



$safes = $safe->oldest()->pluck('name', 'id')->toArray();


$employees = $employee->where('working_status','work')->latest()->pluck('name', 'id')->toArray();
?>

<div class="row">
    <div class="col-md-6">
        {!! Field::date('date' , trans('main.date') ) !!}
    </div>
    <div class="col-md-6">
        {!! Field::floatOnly('amount' , trans('main.amount') ) !!}
    </div>
</div>


<div class="row">
    <div class="col-md-6">

        {!! Field::multiSelect('employee_ids' , trans('main.employees'),$employees,trans('main.select_employee')) !!}
    </div>
    <div class="col-md-6">

        {!! Field::select('safe_id' , trans('main.safe'),$safes,trans('main.select_safe')) !!}
    </div>


</div>


{!! Field::textarea('details' , trans('main.details') ) !!}

