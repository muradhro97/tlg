@include('partials.validation-errors')

@inject('organization','App\Organization')
@inject('project','App\Project')
@inject('employee','App\Employee')
@inject('category','App\Category')
{{--@inject('labors_department','App\LaborsDepartment')--}}
<?php


$organizations = $organization->latest()->pluck('name', 'id')->toArray();


//$labors_departments = $labors_department->latest()->pluck('name', 'id')->toArray();
$projects = $project->latest()->pluck('name', 'id')->toArray();
$employees = $employee->latest()->pluck('name', 'id')->toArray();
//$categories = $category->latest()->where('main_category', 0)->get();
//dd($categories);
//$laborsTypeOptions = [
//
//
//    'na' => trans('main.na'),
//    'all' => trans('main.all'),
//    'supervisor' => trans('main.supervisor'),
//    'technical' => trans('main.technical'),
//    'assistant' => trans('main.assistant'),
//    'worker' => trans('main.worker'),
//];

?>

<div class="row">
    <div class="col-md-6">

        {!! Field::date('date' , trans('main.date') ) !!}
    </div>
    <div class="col-md-6">
        {!! Field::floatOnly('amount' , trans('main.amount') ) !!}

    </div>

</div>
<div class="row">
    <div class="col-md-6">

        {!! Field::select('organization_id' , trans('main.organization'),$organizations,trans('main.select_organization')) !!}
    </div>
    <div class="col-md-6">
        {!! Field::select('project_id' , trans('main.project'),$projects,trans('main.select_project')) !!}

    </div>

</div>
{{--<div class="row">--}}
    {{--<div class="col-md-6">--}}

        {{--{!! Field::select('labors_department_id' , trans('main.labors_departments'),$labors_departments,trans('main.labors_departments')) !!}--}}
    {{--</div>--}}
    {{--<div class="col-md-6">--}}
        {{--{!! Field::select('labors_type' , trans('main.labors_type'),$laborsTypeOptions,trans('main.labors_type')) !!}--}}

    {{--</div>--}}

{{--</div>--}}

{{--<div class="row">--}}
    {{--<div class="col-md-6">--}}

{{--        {!! Field::select('main_category' , trans('main.main_category'),$categories,trans('main.select_main_category')) !!}--}}

        {{--<div class="form-group {{ $errors->has('main_category') ? ' has-error' : '' }}" id="main_category_wrap">--}}
            {{--<label for="main_category">{{trans('main.main_category')}}</label>--}}
            {{--<div class="">--}}
                {{--{{dd($categories)}}--}}
                {{--<select name="main_category" class="select2 form-control "--}}
                        {{--id="main_category">--}}
                    {{--<option value="">{{trans('main.select_main_category')}}</option>--}}

                   {{--@foreach($categories as  $category )--}}
                        {{--<option value="{{$category->id}}">{{$category->name}}</option>--}}
                       {{--@endforeach--}}

                {{--</select>--}}
            {{--</div>--}}
            {{--@if ($errors->has('main_category'))--}}
                {{--<span class="help-block">--}}
                {{--<strong>{{ $errors->first('main_category') }}</strong>--}}
            {{--</span>--}}
            {{--@endif--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<div class="col-md-6">--}}
        {{--<div class="form-group {{ $errors->has('category_id') ? ' has-error' : '' }}" id="category_id_wrap">--}}
            {{--<label for="category_id">{{trans('main.category')}}</label>--}}
            {{--<div class="">--}}
                {{--<select name="category_id" class="select2 form-control "--}}
                        {{--id="category_id">--}}
                    {{--<option value="">{{trans('main.select_category')}}</option>--}}

                {{--</select>--}}
            {{--</div>--}}
            {{--@if ($errors->has('category_id'))--}}
                {{--<span class="help-block">--}}
                {{--<strong>{{ $errors->first('category_id') }}</strong>--}}
            {{--</span>--}}
            {{--@endif--}}
        {{--</div>--}}

    {{--</div>--}}

{{--</div>--}}

<div class="row">
    <div class="col-md-6">

        {!! Field::select('employee_id' , trans('main.submitted_by'),$employees,trans('main.select_employee')) !!}
    </div>
    <div class="col-md-6">


        {!! Field::textarea('details' , trans('main.details') ) !!}
    </div>

</div>


<div class="row">
    {{--<div class="col-md-6">--}}


        {{--{!! Field::textarea('details' , trans('main.details') ) !!}--}}
    {{--</div>--}}
    {{--<div class="col-md-6">--}}


        {{--{!! Field::textarea('description' , trans('main.description') ) !!}--}}
    {{--</div>--}}

</div>


@include('partials.images_uploader')

@push('script')
    {{--<script src="{{asset('assets/admin/plugins/axios/axios.js')}}"></script>--}}
    {{--<script>--}}

        {{--$(document).on('change', '#main_category', function () {--}}

            {{--let id = $(this).val();--}}


            {{--if (id !== '') {--}}
{{--//                    alert();--}}

                {{--let url = "{{request()->getBaseUrl()}}/admin/sub-cats";--}}

                {{--axios.post(url, {id})--}}
                    {{--.then((res) => {--}}

                        {{--$("#category_id").html(res.data.data);--}}


                    {{--}).catch((err) => {--}}
                    {{--console.log(err);--}}
                {{--})--}}
            {{--} else {--}}
                {{--$("#state").html(`<option value=""> {{trans('front.state')}}</option>`);--}}
                {{--$("#city").html(`<option value=""> {{trans('front.city')}}</option>`);--}}
                {{--$("#category_id").html('<option value="">{{trans('main.select_category')}}</option>').trigger('change');--}}
{{--                $("#state_id").html('<option value="">{{trans('main.select_state')}}</option>').trigger('change');--}}
            {{--}--}}
        {{--});--}}


    {{--</script>--}}
@endpush
