@include('partials.validation-errors')


@inject('employee','App\Employee')


@inject('item','App\ExtractItem')

@inject('project','App\Project')
@inject('organization','App\Organization')
@inject('contracts','App\Contract')
@inject('contractType','App\ContractType')
<?php

$organizations = $organization->where('type','mainContractor')->latest()->pluck('name', 'id')->toArray();
$projects = $project->latest()->pluck('name', 'id')->toArray();


$contracts = $contracts->latest()->pluck('no', 'id')->toArray();
$contractTypes = $contractType->latest()->pluck('name', 'id')->toArray();

if (empty($model->getAttributes())) {
    $items = $item->where('is_minus', 0)->latest()->get();
} else {
    $items = $model->contract->items;
}

$minus_items = $item->where('is_minus' , 1)->latest()->get();


$new_items =[];
$new_items_minus =[];

foreach($items as $item){
    $item->name =  $item->item->name  .' | '.$item->item->unit->name ?? '';
}
foreach($minus_items as $item){
    $new_items_minus[$item->id]= $item->name  .' | '.$item->unit->name ?? '';
}


?>
<input type="hidden" name="total" id="total">
<input type="hidden" name="items" id="items">
<div class="row">
    <div class="col-md-6">

        {!! Field::date('date' , trans('main.date') ) !!}
    </div>
    <div class="col-md-6">

        {!! Field::select('organization_id' , trans('main.organization'),$organizations,trans('main.select_organization')) !!}
    </div>


</div>
<div class="row">
    <div class="col-md-6" id="main_contract_container">
        {!! Field::select('contract_id' , trans('main.contract'),$contracts,trans('main.select_contract')) !!}
    </div>
    <div class="col-md-6">

        {!! Field::text('number' , trans('main.number') ) !!}
    </div>
{{--    <div class="col-md-6">--}}

{{--        {!! Field::select('project_id' , trans('main.project'),$projects,trans('main.select_project')) !!}--}}
{{--    </div>--}}

</div>
<div class="row">

    <div class="col-sm-6">
        <div class="form-group {{ $errors->has('period_from') ? ' has-error' : '' }}" id="period_from_wrap">
            <label for="filter-from"> {{trans('main.period_from')}}</label>

            {{--<input type="text" class="form-control">--}}
            <div class="input-group date ">
                {{Form::text('period_from',null, [
                                "placeholder" => trans('main.period_from'),
                                "class" => "form-control",
                                "id" => 'filter-from'
                            ]) }}

                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            </div>


            @if ($errors->has('period_from'))
                <span class="help-block">
                <strong>{{ $errors->first('period_from') }}</strong>
            </span>
            @endif
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group {{ $errors->has('period_to') ? ' has-error' : '' }}" id="period_to_wrap">
            <label for="filter-to">{{trans('main.period_to')}}</label>

            {{--<input type="text" class="form-control">--}}
            <div class="input-group date ">
                {{Form::text('period_to', null, [
                                              "placeholder" => trans('main.period_to'),
                                              "class" => "form-control",
                                              "id" => 'filter-to'
                                          ]) }}

                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            </div>


            @if ($errors->has('period_to'))
                <span class="help-block">
                <strong>{{ $errors->first('period_to') }}</strong>
            </span>
            @endif
        </div>
    </div>
</div>

{{--<div class="row">--}}

    {{--<div class="col-md-6">--}}
        {{--{!! Field::select('contract_type_id' , trans('main.contract_type'),$contractTypes,trans('main.contract_type')) !!}--}}

    {{--</div>--}}

{{--</div>--}}





{!! Field::textarea('details' , trans('main.details') ) !!}



<div class=" row">
    <div class="col-xs-3" id="items_container" style="padding-right: 5px;">

        @if(!empty($model->getAttributes()))
            <select class="form-control select2 select2-hidden-accessible" id="item_id" name="item_id" tabindex="-1" aria-hidden="true">
                @foreach($items as $item)
                    <option data-price="{{$item->price}}" value="{{$item->item_id}}">{{$item->name}}</option>
                @endforeach
            </select>
        @endif
    </div>
    <div class="col-xs-3" style="padding-right: 5px;">

        {{--<input type="text" class="form-control">--}}
        {{Form::text('quantity', null, [   "placeholder" => trans('main.quantity'),"class" => "form-control floatonly",   ])}}
        <span class="help-block text-danger"><strong></strong></span>
    </div>
{{--    <div class="col-xs-3" style="padding-right: 5px;">--}}
{{--        {{Form::text('price', null, [  "placeholder" =>trans('main.price'), "class" => "form-control floatWithNegative ", ])}}--}}
{{--        <span class="help-block text-danger"><strong></strong></span>--}}
{{--    </div>--}}
    <div class="col-xs-2" style="padding-right: 5px;">

        {{Form::text('exchange_ratio', null, [  "placeholder" =>trans('main.exchange_ratio'), "class" => "form-control numberonly", ])}}
        <span class="help-block text-danger"><strong></strong></span>
    </div>
    <div class="col-xs-1" style="padding-right: 5px;">
        <button type="button" class="btn btn-success" id="add-item">Add</button>
    </div>

</div>

<div class=" row">
    <div class="col-xs-3" style="padding-right: 5px;">

        {{Form::select('item_id_minus', $new_items_minus, null, [
                                         "class" => "form-control select2 " ,
                                         "id" => "item_id_minus" ,

                                         "placeholder" =>trans('main.item_name')
                                     ])}}
    </div>
    <div class="col-xs-3" style="padding-right: 5px;">
        {{Form::text('price_minus', null, [  "placeholder" =>trans('main.price'), "class" => "form-control floatWithNegative ", ])}}
        <span class="help-block text-danger"><strong></strong></span>
    </div>
    <div class="col-xs-1" style="padding-right: 5px;">
        <button type="button" class="btn btn-success" id="add-item_minus">Add</button>
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
        <th>exchange ratio</th>
        <th>total</th>

        <th class="text-center">Delete</th>
        </thead>
        <tbody class="item-append-area">

        <tr>

        </tr>


        </tbody>
        <tfoot>
        <tr style=" border: 2px dashed #3c8dbc;">
            <td colspan="4">Net</td>
            <td colspan="2" class="total">0</td>
        </tr>
        </tfoot>
    </table>
</div>
<hr>


@include('partials.images_uploader')

@push('script')
    <script src="{{asset('assets/admin/plugins/axios/axios.js')}}"></script>
    <script>

        $(document).on('change', '#main_category', function () {

            let id = $(this).val();


            if (id !== '') {
//                    alert();

                let url = "{{request()->getBaseUrl()}}/admin/sub-cats";

                axios.post(url, {id})
                    .then((res) => {

                        $("#category_id").html(res.data.data);


                    }).catch((err) => {
                    console.log(err);
                })
            } else {
                {{--$("#state").html(`<option value=""> {{trans('front.state')}}</option>`);--}}
                {{--$("#city").html(`<option value=""> {{trans('front.city')}}</option>`);--}}
                $("#category_id").html('<option value="">{{trans('main.select_category')}}</option>').trigger('change');
                {{--                $("#state_id").html('<option value="">{{trans('main.select_state')}}</option>').trigger('change');--}}
            }
        });


    </script>
@endpush

