@include('partials.validation-errors')

@inject('country','App\Country')



<?php

$countries = $country->latest()->pluck('name', 'id')->toArray();
?>

{!! Field::select('country_id' , trans('main.country'),$countries, trans('main.country')) !!}
{!! Field::text('name' , trans('main.name') ) !!}






