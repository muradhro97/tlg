@include('partials.validation-errors')


<?php
$typeOptions = [


    'employee' => trans('main.employee'),
    'worker' => trans('main.worker'),

];
?>

{!! Field::text('name' , trans('main.name') ) !!}

{{--{!! Field::select('type' , trans('main.type'),$typeOptions, trans('main.type')) !!}--}}

{!! Field::text('abbreviation' , trans('main.abbreviation') ) !!}







