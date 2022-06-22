@include('partials.validation-errors')
@inject('organization','App\Organization')
@inject('project','App\Project')
@inject('contractType','App\ContractType')
@inject('country','App\Country')

@inject('state','App\State')
@inject('city','App\City')

@inject('unit','App\Unit')

@inject('item','App\ExtractItem')


<?php

$units = $unit->latest()->pluck('name', 'id')->toArray();
$items = $item->latest()->get();
$new_items =[];
foreach ($items as $item) {
    $new_items[$item->id] = $item->name . ' | ' . $item->unit->name ?? '';
}
$countries = $country->latest()->select('name', 'id')->get();
$states = $state->latest()->select('name', 'id')->get();
$cities = $city->latest()->select('name', 'id')->get();

$organizations = $organization->latest()->pluck('name', 'id')->toArray();
//dd($organizations);
$projects = $project->latest()->pluck('name', 'id')->toArray();
$contractTypes = $contractType->latest()->pluck('name', 'id')->toArray();

$statusOptions = [

    'notStart' => trans('main.notStart'),
    'active' => trans('main.active'),
    'onhold' => trans('main.onhold'),
    'closed' => trans('main.closed'),
    'extended' => trans('main.extended'),


];
?>


{{--<div class="row">--}}
    {{--<div class="col-md-6">--}}
        {{--{!! Field::date('date' , trans('main.date') ) !!}--}}
    {{--</div>--}}
    {{--<div class="col-md-6">--}}
        {{--{!! Field::text('no' , trans('main.no') ) !!}--}}

    {{--</div>--}}

{{--</div>--}}

@include('flash::message')
<input type="hidden" name="total" id="total">
<input type="hidden" name="items" id="items">

<div class="row">

    <div class="col-md-6">
        {!! Field::date('date' , trans('main.date') ) !!}
    </div>
    <div class="col-md-6">
        {!! Field::select('type_id' , trans('main.type'),$contractTypes, trans('main.type')) !!}

    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="row">


            <div class="col-md-10 col-sm-8 col-xs-8">
                <div class="form-group  {{ $errors->has('project_id') ? ' has-error' : '' }}" id="project_id_wrap">
                    <label for="client_id">{{trans('main.project')}}</label>
                    <div class="">
                        {{  Form::select('project_id', $projects, null, [
                         "class" => "form-control  select2" ,
                         "id" => "project_id",

                         "placeholder" => trans('main.project')
                         ]) }}
                        @if ($errors->has('project_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('project_id') }}</strong>
                       </span>
                        @endif
                    </div>

                </div>
            </div>
            <div class="col-md-2  col-sm-4 col-xs-4">
                <div class="form-group">
                    <label></label>
                    <div>

                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#clientModal">
                            {{trans('main.new')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        {!! Field::select('organization_id' , trans('main.organization'),$organizations, trans('main.organization')) !!}

    </div>

</div>

<div class="row">
{{--    <div class="col-md-6">--}}

{{--        <div class="form-group @error('price') has-error @enderror" id="price_wrap">--}}
{{--            <label for="price">{{trans('main.price')}}</label>--}}
{{--            <div class="input-group m-b">--}}
{{--                {{ Form::text('price', null, [--}}
{{--                "placeholder" => trans('main.price'),--}}
{{--                "class" => "form-control floatonly2",--}}
{{--                "id" => "price"--}}
{{--                ]) }}--}}
{{--                <span class="input-group-addon">{{trans('main.egp')}}</span>--}}
{{--                <span class="help-block text-danger"><strong></strong></span>--}}
{{--            </div>--}}
{{--            @error('price')--}}
{{--            <span class="help-block"><strong>{{ $message }}</strong></span>--}}
{{--            @enderror--}}

{{--        </div>--}}

{{--    </div>--}}
{{--    <div class="col-md-6">--}}
{{--        <div class="form-group @error('duration') has-error @enderror" id="duration_wrap">--}}
{{--            <label for="duration">{{trans('main.duration')}}</label>--}}
{{--            <div class="input-group m-b">--}}
{{--                {{ Form::text('duration', null, [--}}
{{--                "placeholder" => trans('main.duration'),--}}
{{--                "class" => "form-control numberonly2",--}}
{{--                "id" => "duration"--}}
{{--                ]) }}--}}
{{--                <span class="input-group-addon">{{trans('main.day')}}</span>--}}

{{--            </div>--}}
{{--            @error('duration')--}}
{{--            <span class="help-block"><strong>{{ $message }}</strong></span>--}}
{{--            @enderror--}}
{{--        </div>--}}
{{--    </div>--}}

</div>
<div class="row">

    <div class="col-sm-6">
        <div class="form-group {{ $errors->has('start_date') ? ' has-error' : '' }}" id="start_date_wrap">
            <label for="filter-from"> {{trans('main.start_date')}}</label>

            {{--<input type="text" class="form-control">--}}
            <div class="input-group date ">
                {{Form::text('start_date',null, [
                                "placeholder" => trans('main.start_date'),
                                "class" => "form-control",
                                "id" => 'filter-from'
                            ]) }}
                {{--<input type="text" name="start_date" class="  form-control" id="filter-from"--}}
                {{--value="" placeholder="من">--}}
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            </div>


            @if ($errors->has('start_date'))
                <span class="help-block">
                <strong>{{ $errors->first('start_date') }}</strong>
            </span>
            @endif
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group {{ $errors->has('finish_date') ? ' has-error' : '' }}" id="finish_date_wrap">
            <label for="filter-to">{{trans('main.finish_date')}}</label>

            {{--<input type="text" class="form-control">--}}
            <div class="input-group date ">
                {{Form::text('finish_date', null, [
                                              "placeholder" => trans('main.finish_date'),
                                              "class" => "form-control",
                                              "id" => 'filter-to'
                                          ]) }}
                {{--<input type="text" name="finish_date" class="  form-control" id="filter-to"--}}
                {{--value="" placeholder="الى">--}}
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            </div>


            @if ($errors->has('finish_date'))
                <span class="help-block">
                <strong>{{ $errors->first('finish_date') }}</strong>
            </span>
            @endif
        </div>
    </div>
</div>

<div class="row">
    {{--<div class="col-sm-6">--}}
    {{--{!! Field::select('country_id' , trans('main.country'),$countries,trans('main.select_country')) !!}--}}

    {{--</div>--}}
    <div class="col-sm-6">
        <div class="form-group {{ $errors->has('country_id') ? ' has-error' : '' }}" id="country_id_wrap">
            <label for="country_id">{{trans('main.country')}}</label>
            <div class="">
                <select name="country_id" class="select2 form-control "
                        id="country_id">
                    <option value="">{{trans('main.select_country')}}</option>
                    @foreach($countries as $country)
                        <option @if($model->city &&  $model->city->state && ($country->id ==  $model->city->state->country_id ?? 0)) selected
                                @endif value="{{$country->id}}"> {{$country->name}}</option>
                    @endforeach
                </select>
            </div>
            @if ($errors->has('country_id'))
                <span class="help-block">
                <strong>{{ $errors->first('country_id') }}</strong>
            </span>
            @endif
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group {{ $errors->has('state_id') ? ' has-error' : '' }}" id="state_id_wrap">
            <label for="state_id">{{trans('main.state')}}</label>
            <div class="">
                <select name="state_id" class="select2 form-control "
                        id="state_id">
                    <option value="">{{trans('main.select_state')}}</option>
                    @if($model->city   &&  $model->city->state)
                        @foreach($states as $state)
                            {{--                                                <option value=""> {{$state->id}}</option>--}}

                            <option @if(  $model->city && ($state->id ==  $model->city->state_id ?? 0)) selected
                                    @endif value="{{$state->id}}"> {{$state->name}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            @if ($errors->has('state_id'))
                <span class="help-block">
                <strong>{{ $errors->first('state_id') }}</strong>
            </span>
            @endif
        </div>
    </div>
</div>

<div class="row">

    <div class="col-sm-6">
        <div class="form-group {{ $errors->has('city_id') ? ' has-error' : '' }}" id="city_id_wrap">
            <label for="city_id">{{trans('main.city')}}</label>
            <div class="">
                <select name="city_id" class="select2 form-control "
                        id="city_id">
                    <option value="">{{trans('main.select_city')}}</option>
                    @if($model->city   )
                        @foreach($cities as $city)


                            <option @if(  $model->city && ($city->id ==  $model->city_id ?? 0)) selected
                                    @endif value="{{$city->id}}"> {{$city->name}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            @if ($errors->has('city_id'))
                <span class="help-block">
                <strong>{{ $errors->first('city_id') }}</strong>
            </span>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        {!! Field::select('status' , trans('main.status'),$statusOptions, trans('main.status')) !!}

    </div>
</div>
<label for="" class="control-label">{{trans('main.bill_of_quantities')}}</label>


<div class=" row">
    <div class="col-xs-3" style="padding-right: 5px;">

        {{Form::select('item_id', $new_items, null, [
                                         "class" => "form-control select2 " ,
                                         "id" => "item_id" ,

                                         "placeholder" =>trans('main.item_name')
                                     ])}}
    </div>
    <div class="col-xs-3" style="padding-right: 5px;">

        {{--<input type="text" class="form-control">--}}
        {{Form::text('quantity', null, [   "placeholder" => trans('main.quantity'),"class" => "form-control floatonly",   ])}}
        <span class="help-block text-danger"><strong></strong></span>
    </div>
    <div class="col-xs-3" style="padding-right: 5px;">
        {{Form::text('price2', null, [  "placeholder" =>trans('main.price'), "class" => "form-control floatonly", ])}}
        <span class="help-block text-danger"><strong></strong></span>
    </div>
    <div class="col-xs-2" style="padding-right: 5px;">

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
        <th>total</th>

        <th class="text-center">Delete</th>
        </thead>
        <tbody class="item-append-area">

        <tr>

        </tr>

        <tr style=" border: 2px dashed #3c8dbc;">
            <td colspan="3">Net</td>
            <td colspan="2" class="total">0</td>
        </tr>

        </tbody>
    </table>
</div>
<hr>


<div class="clearfix"></div>
<br>

<div class="clearfix"></div>
<br>
{!! Field::textarea('details' , trans('main.details') ) !!}
@include('partials.map_edit')


@push('script')
    <script src="{{asset('assets/admin/plugins/axios/axios.js')}}"></script>
    <script>

        $(document).on('change', '#country_id', function () {

            let id = $(this).val();


            if (id !== '') {
//                    alert();

                let url = "{{request()->getBaseUrl()}}/admin/states";

                axios.post(url, {id})
                    .then((res) => {

                        $("#state_id").html(res.data.data);


                    }).catch((err) => {
                    console.log(err);
                })
            } else {
                {{--$("#state").html(`<option value=""> {{trans('front.state')}}</option>`);--}}
                {{--$("#city").html(`<option value=""> {{trans('front.city')}}</option>`);--}}
                $("#city_id").html('<option value="">{{trans('main.select_city')}}</option>').trigger('change');
                $("#state_id").html('<option value="">{{trans('main.select_state')}}</option>').trigger('change');
            }
        });


        $(document).on('change', '#state_id', function () {
//                alert("edit");
            let id = $(this).val();
//            $(".driverSelect").val(null).trigger('change');
//            $("#city_id").val(null).trigger('change');
//            $("#city_id").html(`<option value="">اختار المدينة</option>`);
            if (id !== '') {


                let url = "{{request()->getBaseUrl()}}/admin/cities";

                axios.post(url, {id})
                    .then((res) => {

                        $("#city_id").html(res.data.data).trigger('change');


                    }).catch((err) => {
//                    console.log(err);
                })
            } else {
//                alert();
                $("#city_id").html('<option value="">{{trans('main.select_city')}}</option>').trigger('change');
            }

        });
        $("#new_phone").click(function () {
//            var tempField = $("#main_phone").clone().find(".phone_values").val("").end();
            // tempField.closest(".phone_values").empty();
            $("#items_box").append(`<div class="row" >
                <div class="col-md-11">
                    <div class="form-group" >



                <div class=" ">

                    <input type="text" name="items[]" class="  form-control"
                           value="" placeholder="" required >

                </div>


            </div>
        </div>

                <div class="col-md-1"><a href="#" class="btn btn-danger" onclick="deleteDynamicPhone(this)"><i
                                class="fa fa-minus-circle"></i></a></div>
            </div>`);
            return false;
        });

        function deleteDynamicPhone(anchor) {
            anchor.closest('.row').remove();
        }

    </script>
@endpush
