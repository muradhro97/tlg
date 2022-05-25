@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.worker_time_sheet'),'url'=>'worker-time-sheet'])
@stop
@section('content')
    @inject('organization','App\Organization')
    @inject('project','App\Project')


    @inject('job','App\WorkerJob')
    @inject('laborsGroup','App\LaborsGroup')


    <?php


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
            <h5>{{trans('main.worker_time_sheet') }}</h5>
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


            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#">
                            {{trans('main.daily')}}
                        </a></li>
                    {{--<li class=""><a href="{{url('admin/invoice/create')}}">Expenses</a></li>--}}
                    <li class=""><a href="{{url('admin/worker-time-sheet-productivity')}}">{{trans('main.productivity')}}</a></li>
                </ul>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="panel-body">


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
                                    <div class="form-group">
                                        <label class="control-label" for="date">{{trans('main.date')}}</label>
                                        <div class="input-group date">

                                            {!! Form::text('date',request()->date ?? \Carbon\Carbon::today()->format('Y-m-d'),[
                                                'class' => 'form-control sheet_date',
                                                'placeholder' => trans('main.date')
                                            ]) !!}
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
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
                                                'action'=>'Admin\WorkerTimeSheetController@store',
                                                'id'=>'myForm',
                                                'role'=>'form',
                                                   'files'=>'true',
                                                'method'=>'POST'
                                                ])!!}
                                <div class="row">
                                    @include('partials.validation-errors')
                                    <input type="hidden" name="date"
                                           value="{{request()->date ?? \Carbon\Carbon::today()->format('Y-m-d')}}">

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label class="control-label"
                                                   for="attendance">{{trans('main.attendance')}}</label>
                                            {{Form::select('attendance', [
                                                'yes'=>trans('main.yes'),
                                                'no'=>trans('main.no'),
                                            ], null, [
                                                "class" => "form-control select2 " ,
                                                "id" => "attendance",
                                                "placeholder" => trans('main.attendance')
                                            ])}}
                                            {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label class="control-label"
                                                   for="overtime">{{trans('main.overtime')}}</label>
                                            {{Form::text('overtime', null, [
                                        "placeholder" => trans('main.hours'),
                                        "class" => "form-control floatonly",
                                        "id" => 'overtime' ])}}
                                            <span class="help-block text-danger"><strong></strong></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label class="control-label"
                                                   for="deduction_hrs">{{trans('main.deduction_hrs')}}</label>
                                            {{Form::text('deduction_hrs', null, [
                                        "placeholder" => trans('main.hours'),
                                        "class" => "form-control floatonly",
                                        "id" => 'deduction_hrs' ])}}
                                            <span class="help-block text-danger"><strong></strong></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label class="control-label"
                                                   for="deduction_value">{{trans('main.deduction_value')}}</label>
                                            {{Form::text('deduction_value', null, [
                                        "placeholder" => trans('main.egp'),
                                        "class" => "form-control floatonly",
                                        "id" => 'deduction_value' ])}}
                                            <span class="help-block text-danger"><strong></strong></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label class="control-label" for="safety">{{trans('main.safety')}}</label>
                                            {{Form::text('safety', null, [
                                        "placeholder" => trans('main.hours'),
                                        "class" => "form-control floatonly",
                                        "id" => 'safety' ])}}
                                            <span class="help-block text-danger"><strong></strong></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label class="control-label" for="details">{{trans('main.details')}}</label>
                                            {{Form::text('details', null, [
                                        "placeholder" => trans('main.details'),
                                        "class" => "form-control ",
                                        "id" => 'details' ])}}
                                            <span class="help-block text-danger"><strong></strong></span>
                                        </div>
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
{{--                                <div class="text-center">--}}
{{--                                    {!! $rows->appends(request()->except('page'))->links() !!}--}}
{{--                                </div>--}}
                                <div class="table-responsive">
                                    <table class="data-table table table-bordered myTable">
                                        <thead>
                                        <th>{{trans('main.select')}}</th>
                                        {{--                        <th>{{trans('main.transaction_no') }}</th>--}}
                                        <th>{{trans('main.id') }}</th>
                                        <th>{{trans('main.name') }}</th>
                                        {{--                        <th>{{trans('main.contract_type') }}</th>--}}
                                        {{--                        <th>{{trans('main.custody_transaction_no') }}</th>--}}
                                        <th>{{trans('main.organization') }}</th>
                                        <th>{{trans('main.project') }}</th>
                                        <th>{{trans('main.job') }}</th>
                                        <th>{{trans('main.labors_group') }}</th>


                                        {{--<th class="text-center">{{trans('main.edit') }}</th>--}}
                                        {{--<th class="text-center">{{trans('main.delete') }}</th>--}}
                                        </thead>
                                        <tbody>
                                        @php $count = 1; @endphp
                                        @foreach($rows as $row)
                                            <tr>
                                                <td><input class="checkbox1" type="checkbox" value="{{$row->id}}" name="ids[]"></td>
                                                {{--                                <td>{{$row->id}}</td>--}}
                                                <td>{{$row->id}}</td>
                                                <td>{{$row->name}}</td>


                                                {{--                                <td>{{$row->safe_transaction_id ?? ''}}</td>--}}

                                                <td>{{$row->organization->name ?? ''}}</td>
                                                <td>{{$row->project->name ?? ''}}</td>
                                                <td>{{$row->job->name ?? ''}}</td>
                                                <td>{{$row->group->name ?? ''}}</td>

                                                {{--<td>{{$row->balance}}</td>--}}
                                                {{--<td>{{$row->new_balance}}</td>--}}


                                                {{--<td class="text-center"><a href="{{url('admin/stock-transaction/'.$row->id.'/edit')}}"--}}
                                                {{--class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a>--}}
                                                {{--</td>--}}
                                                {{--<td class="text-center">--}}
                                                {{--{{Form::open(array('method'=>'delete','class'=>'delete','url'=>url('admin/stock-transaction/'.$row->id) )) }}--}}
                                                {{--<button type="submit" class="destroy btn btn-danger btn-xs"><i--}}
                                                {{--class="fa fa-trash-o"></i></button>--}}
                                                {{--{{Form::close()}}--}}
                                                {{--</td>--}}
                                            </tr>
                                            @php $count ++; @endphp
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>


                                {!! Form::close()!!}
                            @else
                                <h2 class="text-center">{{trans('main.no_records') }}</h2>
                            @endif
                            <div class="clearfix"></div>


                        </div>
                    </div>
                </div>
            </div>


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
