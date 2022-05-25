@include('partials.validation-errors')


@inject('employee','App\Employee')


<?php

$employees = $employee->latest()->pluck('name', 'id')->toArray();
?>


{!! Field::select('employee_id' , trans('main.employees'),$employees,trans('main.select_employee')) !!}

{!! Field::date('date' , trans('main.date') ) !!}

{!! Field::floatOnly('amount' , trans('main.amount') ) !!}
{!! Field::textarea('details' , trans('main.details') ) !!}










