@include('partials.validation-errors')

@inject('state','App\State')



<?php

$states = $state->latest()->pluck('name', 'id')->toArray();
?>

{!! Field::select('state_id' , trans('main.state'),$states, trans('main.state')) !!}
{!! Field::text('name' , trans('main.name') ) !!}






