@include('partials.validation-errors')
@inject('unit','App\Unit')
@inject('employee','App\Employee')
@inject('worker','App\Worker')
@inject('item','App\Item')
@inject('stockType','App\StockType')
@inject('project','App\Project')


<?php

$custodyTypeOptions = [


    'permanent' => trans('main.permanent'),
    'consumed' => trans('main.consumed'),
    'refundable' => trans('main.refundable'),
];
$projects = $project->latest()->pluck('name', 'id')->toArray();
$units = $unit->latest()->pluck('name', 'id')->toArray();
$items = $item->latest()->get();
$employees = $employee->latest()->pluck('name', 'id')->toArray();
$workers = $worker->latest()->pluck('name', 'id')->toArray();
$stockTypes = $stockType->latest()->pluck('name', 'id')->toArray();
//foreach ($items as $item) {
//    $new_items[$item->id] = $item->name . ' | ' . $item->unit->name ?? '';
//}
?>
<input type="hidden" name="total" id="total">
<input type="hidden" name="items" id="items">
<div class="row">
    <div class="col-md-6">
        {!!Field::select('human_type',trans('main.Human Type'), [
                                'employee'=>trans('main.employee'),
                                'worker'=>trans('main.worker'),
                                ])!!}
    </div>
    <div class="col-md-6" id="employee_container">
        {!! Field::select('employee_id' , trans('main.employee'),$employees,trans('main.select_employee')) !!}
    </div>
    <div class="col-md-6" id="worker_container">
        {!! Field::select('worker_id' , trans('main.worker'),$workers,trans('main.select_worker')) !!}
    </div>
    <div class="col-md-6">
        {!! Field::date('date' , trans('main.date') ) !!}

    </div>

</div>

<div class="row">
    <div class="col-md-6">

        {!! Field::select('custody_type' , trans('main.custody_type'),$custodyTypeOptions,trans('main.select_custody_type')) !!}
    </div>
    <div class="col-md-6">
        {!! Field::select('stock_type' , trans('main.stock_type'),$stockTypes,trans('main.select_stock_type')) !!}

        {{--        {!! Field::select('employee_id' , 'Stock type',$units,'Stock type') !!}--}}

    </div>

</div>
<div class="row">


    <div class="col-md-6">
        {!! Field::select('project_id' , trans('main.project'),$projects,trans('main.project')) !!}

    </div>
    {{--<div class="col-md-6">--}}
        {{--{!! Field::select('approved_by' , trans('main.approved_by'),$employees,trans('main.approved_by')) !!}--}}

    {{--</div>--}}
</div>
{!! Field::textarea('details' , trans('main.details') ) !!}

{{--{!! Field::select('employee_id' , trans('main.employee'),$units,trans('main.select_employee')) !!}--}}
{{--{!! Field::text('date' , trans('main.date') ) !!}--}}
{{--{!! Field::select('Custody Type' , 'Custody Type',$units,' select Custody Type') !!}--}}

{{--{!! Field::select('employee_id' , 'Stock type',$units,'Stock type') !!}--}}
{{--{!! Field::select('item_id' , trans('main.item'),$units,trans('main.select_item')) !!}--}}
{{--{!! Field::text('Quantity' , 'Quantity' ) !!}--}}
{{--{!! Field::text('Unit Price' , 'Unit Price' ) !!}--}}
{{--{!! Field::textReadOnly('Total Price' , 'Total Price' ) !!}--}}


{{--{!! Field::select('employee_id' , 'approved by',$units,'approved by') !!}--}}
{{--{!! Field::text('initial_quantity' , trans('main.initial_quantity') ) !!}--}}


{{--<label for="" class="control-label">{{trans('main.bill_of_quantities')}}</label>--}}

<div class=" row">
    <div class="col-xs-3" style="padding-right: 5px;">
        <select name="item_id" id="item_id" class="form-control select2">

            <option data-quantity="0" value="">{{trans('main.item_name')}}</option>
            @foreach($items As $item)
{{--                <option data-quantity="{{$item->quantity}}"--}}
{{--                        value="{{$item->id}}">{{$item->name .'|'. $item->unit->name ?? ''}}</option>--}}
                <option
                        value="{{$item->id}}">{{$item->name .'|'. $item->unit->name ?? ''}}</option>
            @endforeach
        </select>
        {{--{{Form::select('item_id', $new_items, null, [--}}
        {{--"class" => "form-control select2 " ,--}}
        {{--"id" => "item_id" ,--}}

        {{--"placeholder" =>trans('main.item_name')--}}
        {{--])}}--}}
    </div>
    <div class="col-xs-3" style="padding-right: 5px;">
        {{--<input type="text" class="form-control">--}}
        {{Form::text('quantity', null, [   "placeholder" => trans('main.quantity'),"class" => "form-control floatonly ","id" => "quantity", 'disabled'=>'disabled'  ])}}
        <span class="help-block text-danger"><strong></strong></span>
    </div>
    <div class="col-xs-3" style="padding-right: 5px;">
        {{Form::text('price', null, [  "placeholder" =>trans('main.price'), "class" => "form-control floatonly",'disabled'=>'disabled' ])}}
        <span class="help-block text-danger"><strong></strong></span>
    </div>

    <div class="col-xs-3" style="padding-right: 5px;" id="size_container">

    </div>

    <div class="col-xs-3" style="padding-right: 5px;" id="color_container">

    </div>
    <div class="col-xs-3" style="padding-right: 5px;">
        {{Form::checkbox('is_manual_price', true)}}
        <span class="help-block"><strong>{{trans('main.force_price')}}</strong></span>
    </div>

    <div class="col-xs-2" style="padding-right: 5px;">
        <button type="button" class="btn btn-success" id="add-item">Add</button>
    </div>

</div>
<hr>
<div class="table-responsive">
    <table class="data-table table table-bordered">
        <thead>
        {{--<th>#</th>--}}
        <th>Item Name</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Color</th>
        <th>Size</th>
        <th>total</th>

        <th class="text-center">Delete</th>
        </thead>
        <tbody class="item-append-area">

        <tr>

        </tr>

        <tr style=" border: 2px dashed #3c8dbc;">
            <td colspan="5">Net</td>
            <td colspan="2" class="total">0</td>
        </tr>

        </tbody>
    </table>
</div>
<hr>






