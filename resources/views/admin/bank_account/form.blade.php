@include('partials.validation-errors')





{!! Field::text('name' , trans('main.name') ) !!}
{!! Field::floatOnly('initial_balance' , trans('main.initial_balance') ) !!}






