@include('partials.validation-errors')


{!! Field::text('name' , trans('main.name') ) !!}
{!! Field::floatOnly('unit_price' , trans('main.unit_price') ) !!}






