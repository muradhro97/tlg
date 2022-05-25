@include('partials.validation-errors')


<?php
$typeOptions = [


    'employee' => trans('main.employee'),
    'worker' => trans('main.worker'),

];
?>

{!! Field::text('name' , trans('main.name') ) !!}
{!! Field::floatOnly('daily_salary' , trans('main.daily_salary') ) !!}
{!! Field::floatOnly('hourly_salary' , trans('main.hourly_salary') ) !!}
{!! Field::floatOnly('insurance' , trans('main.insurance') ) !!}
{!! Field::floatOnly('taxes' , trans('main.taxes') ) !!}

{{--{!! Field::select('type' , trans('main.type'),$typeOptions, trans('main.type')) !!}--}}

{!! Field::text('abbreviation' , trans('main.abbreviation') ) !!}





