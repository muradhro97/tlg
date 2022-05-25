@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.worker_time_sheet_history'),'url'=>'worker-time-sheet-history'])
@stop
@section('content')
    @inject('organization','App\Organization')
    @inject('project','App\Project')
    @inject('job','App\Job')

    @inject('laborsDepartment','App\LaborsDepartment')

    @inject('worker','App\Worker')
    @inject('laborsGroup','App\LaborsGroup')


    <?php


    $organizations = $organization->latest()->pluck('name', 'id')->toArray();
    $laborsGroups = $laborsGroup->latest()->pluck('name', 'id')->toArray();
    $jobs = $job->where('type','worker')->latest()->pluck('name', 'id')->toArray();

    $projects = $project->latest()->whereIn('id', auth()->user()->projects->pluck('id')->toArray())->pluck('name', 'id')->toArray();



    $departments = $laborsDepartment->latest()->pluck('name', 'id')->toArray();
    $workers = $worker->latest()->pluck('name', 'id')->toArray();
    ?>
    <div class="ibox ibox-primary">
        <div class="ibox-title">
            <h5>{{trans('main.search') }}</h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
                <a class="close-link">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content m-b-sm border-bottom">

            {!! Form::open([
                  'method' => 'GET'
              ]) !!}
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="worker_id">{{trans('main.worker')}}</label>
                        {{Form::select('worker_id', $workers,  request()->worker_id, [
                            "class" => "form-control select2 " ,
                            "id" => "worker_id",
                            "placeholder" => trans('main.worker')
                        ])}}
                        {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="worker_id">{{trans('main.job')}}</label>
                        {{Form::select('job_id', $jobs,  request()->job_id, [
                            "class" => "form-control select2 " ,
                            "id" => "job_id",
                            "placeholder" => trans('main.job')
                        ])}}
                        {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="project_id">{{trans('main.project')}}</label>
                        {{Form::select('project_id', $projects,  request()->project_id, [
                            "class" => "form-control select2 " ,
                            "id" => "project_id",
                            "placeholder" => trans('main.project')
                        ])}}
                        {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="organization_id">{{trans('main.organization')}}</label>
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
                        <label class="control-label" for="department_id">{{trans('main.department')}}</label>
                        {{Form::select('department_id', $departments, request()->department_id, [
                            "class" => "form-control select2 " ,
                            "id" => "department_id",
                            "placeholder" => trans('main.department')
                        ])}}
                        {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="labors_group_id">{{trans('main.labors_groups')}}</label>
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
                        <label class="control-label" for="date">{{trans('main.from')}}</label>
                        <div class="input-group date">

                            {!! Form::text('from',request()->from,[
                                'class' => 'form-control ',
                                'placeholder' => trans('main.from'),
                                 "id" => 'filter-from'
                            ]) !!}
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="to">{{trans('main.to')}}</label>
                        <div class="input-group date">

                            {!! Form::text('to',request()->to,[
                                'class' => 'form-control ',
                                'placeholder' => trans('main.to'),
                                 "id" => 'filter-to'
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
        </div>
    </div>
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
            {{--<div class="">--}}
            {{--<a href="{{url('admin/worker-time-sheet/create')}}" class="btn btn-primary">--}}
            {{--<i class="fa fa-plus"></i> {{trans('main.new') }}--}}
            {{--</a>--}}
            {{--</div>--}}
            @if($rows->count()>0)

                {!! Form::model($model,[
                                                'action'=>['Admin\WorkerTimeSheetController@updateAll'],
                                                'id'=>'myForm',
                                                'role'=>'form',
                                                'method'=>'POST'
                                                ])!!}
                <div class="ibox-content">
                    @include('admin.worker_time_sheet.form_edit')
                </div>
                <div class="ibox-footer">
                    <div class="row">
                        <button type="submit" class="btn btn-primary disableOnSubmit">{{trans('main.save')}}</button>
                    </div>
                </div>
                <a href="{{route('worker_time_sheet_history.export',$request->all())}}" class="btn btn-primary">
                    <i class="fa fa-file-excel-o"></i>
                    {{trans('main.excel')}}
                </a>
                <div class="table-responsive">
                    <table class="footable table table-bordered toggle-arrow-tiny " data-sort="false">
                        <thead>
                        <th>#</th>
                        <th>{{trans('main.date') }}</th>
                        <th>{{trans('main.attendance') }}</th>
                        <th>{{trans('main.worker') }}</th>
                        <th>{{trans('main.job') }}</th>
                        <th data-hide="all">{{trans('main.project') }}</th>
                        <th data-hide="all">{{trans('main.organization') }}</th>
                        <th data-hide="all">{{trans('main.department') }}</th>
                        <th data-hide="all">{{trans('main.labors_group') }}</th>
                        {{--<th>{{trans('main.type') }}</th>--}}
                        {{--<th>{{trans('main.productivity') }}</th>--}}
                        {{--<th>{{trans('main.unit_price') }}</th>--}}
                        <th>{{trans('main.overtime') }}</th>
                        <th>{{trans('main.deduction_hrs') }}</th>
                        <th>{{trans('main.deduction_value') }}</th>
                        <th>{{trans('main.safety') }}</th>
                        <th>{{trans('main.additions') }}</th>
                        <th>{{trans('main.discounts') }}</th>
                        <th>{{trans('main.total') }}</th>
                        <th>{{trans('main.details') }}</th>
                        @can('editWorTime')
                            <th class="text-center">{{trans('main.edit') }}</th>
                        @endcan
                        @can('deleteWorTime')
                            <th class="text-center">{{trans('main.delete') }}</th>
                        @endcan
                        </thead>
                        <tbody>

                        @foreach($rows as $row)
                            <?php
                            $iteration = $loop->iteration
                            ?>
                            <tr>
                                <td>
                                    {{$iteration}}
                                    <input class="checkbox1" type="checkbox" value="{{$row->id}}" name="ids[]">
                                </td>
                                <td>{{$row->date}}</td>
                                <td>{{$row->attendance}}</td>
                                <td>{{$row->worker->name ?? ''}}</td>
                                <td>{{$row->worker->job->name ?? ''}}</td>
                                <td>{{$row->worker->project->name ?? ''}}</td>
                                <td>{{$row->worker->organization->name ?? ''}}</td>
                                <td>{{$row->worker->department->name ?? ''}}</td>
                                <td>{{$row->worker->group->name ?? ''}}</td>
                                {{--<td>{{$row->type}}</td>--}}
                                {{--<td>{{$row->productivity}}</td>--}}
                                {{--<td>{{$row->unit_price}}</td>--}}
                                <td>{{$row->overtime}}</td>
                                <td>{{$row->deduction_hrs}}</td>
                                <td>{{$row->deduction_value}}</td>
                                <td>{{$row->safety}}</td>
                                <td>{{$row->additions}}</td>
                                <td>{{$row->discounts}}</td>
                                <td>{{$row->total}}</td>
                                <td>{{$row->details}}</td>
                                @can('editWorTime')
                                    <td class="text-center"><a
                                                href="{{url('admin/worker-time-sheet/'.$row->id.'/edit')}}"
                                                class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a>
                                    </td>
                                @endcan
                                @can('deleteWorTime')
{{--                                    <td class="text-center">--}}
{{--                                        {{Form::open(array('method'=>'delete','class'=>'delete','url'=>url('admin/worker-time-sheet/'.$row->id) )) }}--}}
{{--                                        <button type="submit" class="destroy btn btn-danger btn-xs"><i--}}
{{--                                                    class="fa fa-trash-o"></i></button>--}}
{{--                                        {{Form::close()}}--}}
{{--                                    </td>--}}
                                    <td class="text-center"><a
                                            href="{{url('admin/worker-time-sheet-history/delete/'.$row->id)}}"
                                            class="destroy btn btn-danger btn-xs deleteGet"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                @endcan

                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                </div>
                {!! Form::close()!!}

                <div class="text-center">
                    {!! $rows->appends(request()->except('page'))->links() !!}
                </div>

            @else
                <h2 class="text-center">{{trans('main.no_records') }}</h2>
            @endif
            <div class="clearfix"></div>
        </div>
    </div>
    @push('style')
        <link href="{{asset('assets/admin/plugins/clockpicker/clockpicker.css')}}" rel="stylesheet">
    @endpush
    @push('script')
        <script src="{{asset('assets/admin/plugins/clockpicker/clockpicker.js')}}"></script>
        <script>
            $(function () {
                $('.clockpicker').clockpicker();

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

            }).datepicker("setDate", today);
        </script>

        <script>
            $(document).ready(function () {
                $('.print_table').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'print',
                            className: 'btn btn-primary  hide-for-mobile',
                            {{--text: "<i class=fa fa-print'></i>  {{trans('main.print')}}",--}}
                            text:      '<i class="fa fa-print"></i> {{trans("main.print")}}',
                            autoPrint: true,
                            title: "",
                            init: function(api, node, config) {
                                $(node).removeClass('dt-button')
                            },
                            exportOptions: {
                                columns: [ 0, 1 ,2,3,4,5,6,7,8,9,10,11,12,13,14,15]
                            }
                        }
                    ],
                    "paging": false,
                    "ordering": false,
                    "searching": false,
                    "info": false
                });
            });

        </script>
    @endpush


@stop
