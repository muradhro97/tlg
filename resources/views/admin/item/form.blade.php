@include('partials.validation-errors')
@inject('unit','App\Unit')
@inject('color','App\Color')
@inject('size','App\Size')


<?php
$typeOptions=[
    'direct'=>trans('main.direct'),
    'indirect'=>trans('main.indirect'),
];

$units = $unit->latest()->pluck('name', 'id')->toArray();
$colors = $color->latest()->pluck('color', 'id')->toArray();
$sizes = $size->latest()->pluck('size', 'id')->toArray();

?>

{!! Field::text('name' , trans('main.name') ) !!}
{{--{!! Field::text('initial_quantity' , trans('main.initial_quantity') ) !!}--}}


{!! Field::select('unit_id' , trans('main.unit'),$units,trans('main.select_unit')) !!}
{!! Field::select('type' , trans('main.type'),$typeOptions,trans('main.select_type')) !!}

<div data-repeater-list="item">
    <div data-repeater-item>
        <hr style="margin-top: 5px;margin-bottom: 5px">
        <div class="row">
            <div class="col-md-3">
                {!! Field::select('color',trans('main.color'),$colors,trans('main.color')) !!}
            </div>
            <div class="col-md-3">
                {!! Field::select('size',trans('main.size'),$sizes,trans('main.size')) !!}
            </div>
            <div class="col-md-3">
                {!! Field::floatOnly('quantity' , trans('main.quantity') ) !!}
            </div>
            <div class="col-md-3" style="line-height: 5.5em;">
                <input data-repeater-delete class="btn btn-danger" type="button" value="{{trans('main.delete')}}"/>
            </div>
        </div>
    </div>
</div>
<input data-repeater-create type="button" class="btn btn-primary" value="{{trans('main.add')}}"/>
{!! Field::textarea('details' , trans('main.details') ) !!}






