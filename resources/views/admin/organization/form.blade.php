@include('partials.validation-errors')

@php
    $types = [
        'owner' => trans('main.owner') ,
        'mainContractor' => trans('main.main_contractor') ,
        'subContractor' => trans('main.sub_contractor') ,
        'supplier' => trans('main.supplier') ,


    ];
@endphp
{!! Field::text('name' , trans('main.name') ) !!}

{!! Field::text('phone' , trans('main.phone') ) !!}
{!! Field::text('tax_no' , trans('main.tax_no') ) !!}
{!! Field::text('commercial_no' , trans('main.commercial_no') ) !!}
{!! Field::select('type' , trans('main.type'),$types,trans('main.type')) !!}
{!! Field::textarea('address' , trans('main.address') ) !!}






