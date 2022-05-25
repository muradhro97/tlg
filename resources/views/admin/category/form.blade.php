@include('partials.validation-errors')
@inject('category','App\Category')

@php
    $categories = [0 => trans('main.main_category')] + $category->where('main_category',0)->pluck('name','id')->toArray();

@endphp


{!! Field::select('main_category',trans('main.main_category'),$categories,null) !!}
{!! Field::text('name' , trans('main.name') ) !!}






