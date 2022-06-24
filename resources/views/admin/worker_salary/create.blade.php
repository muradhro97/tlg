@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.worker_salary'),'url'=>'worker-salary'])
@stop
@section('content')
    @inject('organization','App\Organization')
    @inject('project','App\Project')


    @inject('job','App\WorkerJob')
    @inject('laborsGroup','App\LaborsGroup')


    @inject('safe','App\Safe')

    <?php

    $typeOptions = [
        'daily' => trans('main.daily'),
        'productivity' => trans('main.productivity'),
    ];

    $safes = $safe->oldest()->pluck('name', 'id')->toArray();


    $organizations = $organization->latest()->pluck('name', 'id')->toArray();


    $projects = $project->latest()->whereIn('id', auth()->user()->projects->pluck('id')->toArray())->pluck('name', 'id')->toArray();



    $jobs = $job->latest()->pluck('name', 'id')->toArray();
    $laborsGroups = $laborsGroup->latest()->pluck('name', 'id')->toArray();
    ?>
    {{--<div class="ibox ibox-primary">--}}
    {{--<div class="ibox-title">--}}

    {{--<div class="ibox-tools">--}}
    {{--<a class="collapse-link">--}}
    {{--<i class="fa fa-chevron-up"></i>--}}
    {{--</a>--}}
    {{--<a class="close-link">--}}
    {{--<i class="fa fa-times"></i>--}}
    {{--</a>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="ibox-content m-b-sm border-bottom">--}}


    {{--</div>--}}
    {{--</div>--}}
    <div class="ibox ibox-primary">
        <div class="ibox-title">
            <h5>{{trans('main.worker_salary') }}</h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
                <a class="close-link">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">


            @include('partials.validation-errors')
            {!! Form::open([
                'method' => 'GET'
            ]) !!}
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="project_id">{{trans('main.project')}}</label>
                        {{Form::select('project_id', $projects, request()->project_id, [
                            "class" => "form-control select2 " ,
                            "id" => "project_id",
                            "placeholder" => trans('main.project')
                        ])}}
                        {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label"
                               for="organization_id">{{trans('main.organization')}}</label>
                        {{Form::select('organization_id', $organizations, request()->organization_id, [
                            "class" => "form-control select2 " ,
                            "id" => "organization_id",
                            "placeholder" => trans('main.organization')
                        ])}}
                        {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="job_id">{{trans('main.worker_job')}}</label>
                        {{Form::select('job_id', $jobs, request()->job_id, [
                            "class" => "form-control select2 " ,
                            "id" => "job_id",
                            "placeholder" => trans('main.worker_job')
                        ])}}
                        {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label"
                               for="labors_group_id">{{trans('main.labors_groups')}}</label>
                        {{Form::select('labors_group_id', $laborsGroups, request()->labors_group_id, [
                            "class" => "form-control select2 " ,
                            "id" => "labors_group_id",
                            "placeholder" => trans('main.labors_groups')
                        ])}}
                        {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group "
                         id="start_date_wrap">
                        <label for="filter-from"> {{trans('main.from')}}</label>

                        {{--<input type="text" class="form-control">--}}
                        <div class="input-group date ">
                            {{Form::text('from', request()->from, [
                                            "placeholder" => trans('main.from'),
                                            "class" => "form-control",
                                            "id" => 'filter-from'
                                        ]) }}
                            {{--<input type="text" name="start_date" class="  form-control" id="filter-from"--}}
                            {{--value="" placeholder="من">--}}
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>


                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group"
                         id="finish_date_wrap">
                        <label for="filter-to">{{trans('main.to')}}</label>

                        {{--<input type="text" class="form-control">--}}
                        <div class="input-group date ">
                            {{Form::text('to',  request()->to, [
                                                          "placeholder" => trans('main.to'),
                                                          "class" => "form-control",
                                                          "id" => 'filter-to'
                                                      ]) }}
                            {{--<input type="text" name="finish_date" class="  form-control" id="filter-to"--}}
                            {{--value="" placeholder="الى">--}}
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>


                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label"
                               for="type">{{trans('main.type')}}</label>
                        {{Form::select('type', $typeOptions, request()->type, [
                            "class" => "form-control select2 " ,
                            "id" => "type",
                            "placeholder" => trans('main.type')
                        ])}}
                        {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
                    </div>
                </div>

            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-sm-2 ">
                    <div class="form-group">
                        <label for="">&nbsp;</label>
                        <button type="submit"
                                class="btn btn-flat  btn-primary btn-md">{{trans('main.show') }}</button>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}


            <hr>
            @if($rows->count()>0)
                {!! Form::model($model,[
                                'action'=>'Admin\WorkerSalaryController@store',
                                'id'=>'myForm',
                                'role'=>'form',
                                   'files'=>'true',
                                'method'=>'POST'
                                ])!!}
                <div class="row">
                    @include('partials.validation-errors')
                    <input type="hidden" name="start" value="{{request()->from}}">
                    <input type="hidden" name="end" value="{{request()->to}}">
                    <input type="hidden" name="type" value="{{request()->type}}">
                    <div class="col-md-6">

                        {!! Field::select('safe_id' , trans('main.safe'),$safes,trans('main.select_safe')) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <input type="checkbox" id="salary_changed" name="salary_changed">
                        <label for="salary_changed">  {{trans('main.Salary Changed?')}} </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2 ">
                        <div class="form-group">
                            <label for="">&nbsp;</label>
                            <button type="submit"
                                    class="btn btn-flat disableOnSubmit btn-primary btn-md">{{trans('main.save') }}</button>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <br>



                <div class="row">
                    <div class="col-md-4">
                        <input type="checkbox" id="checkall">
                        <label for="checkall">  {{trans('main.select_all')}} </label>
                    </div>
                </div>

            @include('admin.worker_salary.form')

                {!! Form::close()!!}
            @else
                <h2 class="text-center">{{trans('main.no_records') }}</h2>
            @endif
            <div class="clearfix"></div>


        </div>
    </div>
    @push('script')
        <script>
            $(function () {


                $('#select_all').click(function () {
//                alert();
                    if ($(this).is(':checked')) {
                        $('input[type=checkbox]').prop('checked', true);
                    } else {
                        $('input[type=checkbox]').prop('checked', false);
                    }
                });
            });
            let today = new Date();


            $(".sheet_date").datepicker({
                // dateFormat: 'yy-mm-dd'
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                // setDate: currentDate,
                // regional: "ar" ,
                // yearRange: “c-70:c+10”,
//                isRTL: true,
                changeYear: true,
//                minDate: -0,
                maxDate: 0

            })
//                .datepicker("setDate", today)
            ;

        </script>
    @endpush
@stop
