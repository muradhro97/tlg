@include('partials.validation-errors')
@inject('unit','App\Unit')


<?php


$units = $unit->latest()->pluck('name', 'id')->toArray();

?>

{!! Field::text('name' , trans('main.name') ) !!}
{{--{!! Field::text('initial_quantity' , trans('main.initial_quantity') ) !!}--}}
{{--{!! Field::numberOnly('quantity' , trans('main.quantity') ) !!}--}}
{!! Field::select('unit_id' , trans('main.unit'),$units,trans('main.select_unit')) !!}
{!! Field::textarea('details' , trans('main.details') ) !!}

{!! Form::label(trans('main.is_minus')) !!}
{!! Form::checkbox('is_minus', 1) !!}






