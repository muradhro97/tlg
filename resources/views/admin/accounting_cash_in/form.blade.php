@include('partials.validation-errors')

@inject('organization','App\Organization')
@inject('contract','App\Contract')
@inject('employee','App\Employee')
@inject('safe','App\Safe')
@inject('project','App\Project')

@inject('item','App\ExtractItem')

<?php


$organizations = $organization->latest()->pluck('name', 'id')->toArray();
$projects = $project->latest()->pluck('name', 'id')->toArray();
$safes = $safe->oldest()->pluck('name', 'id')->toArray();


$contracts = $contract->latest()->pluck('no', 'id')->toArray();
$employees = $employee->latest()->pluck('name', 'id')->toArray();

$items = $item->where('is_minus' , 0)->latest()->get();
$minus_items = $item->where('is_minus' , 1)->latest()->get();


$new_items =[];
$new_items_minus =[];

foreach($items as $item){
    $new_items[$item->id]= $item->name  .' | '.$item->unit->name ?? '';
}
foreach($minus_items as $item){
    $new_items_minus[$item->id]= $item->name  .' | '.$item->unit->name ?? '';
}

?>
<input type="hidden" name="amount" id="total">
<input type="hidden" name="items" id="items">
<div class="row">
    <div class="col-md-6">

        {!! Field::date('date' , trans('main.date') ) !!}
    </div>
    <div class="col-md-6">
        {!! Field::floatOnly('total' , trans('main.amount') ) !!}
    </div>

</div>
<div class="row">
    <div class="col-md-6">

        {!! Field::select('organization_id' , trans('main.organization'),$organizations,trans('main.select_organization')) !!}
    </div>
    <div class="col-md-6">
        {!! Field::select('contract_id' , trans('main.contract'),$contracts,trans('main.select_contract')) !!}

    </div>

</div>

<div class="row">
    <div class="col-md-6">

        {!! Field::select('employee_id' , trans('main.submitted_by'),$employees,trans('main.select_employee')) !!}
    </div>
    <div class="col-md-6">

        {!! Field::select('safe_id' , trans('main.safe'),$safes,trans('main.select_safe')) !!}
    </div>


</div>


<div class="row">

    <div class="col-md-6">
        {!! Field::select('project_id' , trans('main.projects'),$projects,trans('main.select_project')) !!}


    </div>
    <div class="col-md-6">
        {!! Field::text('transaction_cheque_no' , trans('main.transaction_cheque_no') ) !!}
    </div>

</div>
{!! Field::textarea('details' , trans('main.details') ) !!}

{{--<div class=" row">--}}
{{--    <div class="col-xs-3" style="padding-right: 5px;">--}}

{{--        {{Form::select('item_id', $new_items, null, [--}}
{{--                                         "class" => "form-control select2 " ,--}}
{{--                                         "id" => "item_id" ,--}}

{{--                                         "placeholder" =>trans('main.item_name')--}}
{{--                                     ])}}--}}
{{--    </div>--}}
{{--    <div class="col-xs-3" style="padding-right: 5px;">--}}

{{--        --}}{{--<input type="text" class="form-control">--}}
{{--        {{Form::text('quantity', null, [   "placeholder" => trans('main.quantity'),"class" => "form-control floatonly",   ])}}--}}
{{--        <span class="help-block text-danger"><strong></strong></span>--}}
{{--    </div>--}}
{{--    <div class="col-xs-3" style="padding-right: 5px;">--}}
{{--        {{Form::text('price', null, [  "placeholder" =>trans('main.price'), "class" => "form-control floatWithNegative ", ])}}--}}
{{--        <span class="help-block text-danger"><strong></strong></span>--}}
{{--    </div>--}}
{{--    <div class="col-xs-2" style="padding-right: 5px;">--}}

{{--        {{Form::text('exchange_ratio', null, [  "placeholder" =>trans('main.exchange_ratio'), "class" => "form-control numberonly", ])}}--}}
{{--        <span class="help-block text-danger"><strong></strong></span>--}}
{{--    </div>--}}
{{--    <div class="col-xs-1" style="padding-right: 5px;">--}}
{{--        <button type="button" class="btn btn-success" id="add-item">Add</button>--}}
{{--    </div>--}}

{{--</div>--}}

{{--<div class=" row">--}}
{{--    <div class="col-xs-3" style="padding-right: 5px;">--}}

{{--        {{Form::select('item_id_minus', $new_items_minus, null, [--}}
{{--                                         "class" => "form-control select2 " ,--}}
{{--                                         "id" => "item_id_minus" ,--}}

{{--                                         "placeholder" =>trans('main.item_name')--}}
{{--                                     ])}}--}}
{{--    </div>--}}
{{--    <div class="col-xs-3" style="padding-right: 5px;">--}}
{{--        {{Form::text('price_minus', null, [  "placeholder" =>trans('main.price'), "class" => "form-control floatWithNegative ", ])}}--}}
{{--        <span class="help-block text-danger"><strong></strong></span>--}}
{{--    </div>--}}
{{--    <div class="col-xs-1" style="padding-right: 5px;">--}}
{{--        <button type="button" class="btn btn-success" id="add-item_minus">Add</button>--}}
{{--    </div>--}}

{{--</div>--}}

{{--<hr>--}}
{{--<div class="table-responsive">--}}
{{--    <table class="data-table table table-bordered">--}}
{{--        <thead>--}}
{{--        --}}{{--<th>#</th>--}}
{{--        <th>Item Name</th>--}}
{{--        <th>Quantity</th>--}}
{{--        <th>Price</th>--}}
{{--        <th>exchange ratio</th>--}}
{{--        <th>total</th>--}}

{{--        <th class="text-center">Delete</th>--}}
{{--        </thead>--}}
{{--        <tbody class="item-append-area">--}}

{{--        <tr>--}}

{{--        </tr>--}}

{{--        <tr style=" border: 2px dashed #3c8dbc;">--}}
{{--            <td colspan="4">Net</td>--}}
{{--            <td colspan="2" class="total">0</td>--}}
{{--        </tr>--}}

{{--        </tbody>--}}
{{--    </table>--}}
{{--</div>--}}
{{--<hr>--}}

@include('partials.images_uploader')
