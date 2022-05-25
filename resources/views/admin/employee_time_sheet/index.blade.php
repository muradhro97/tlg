@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.employee_time_sheet'),'url'=>'employee-time-sheet'])
@stop
@section('content')
    @inject('organization','App\Organization')
    @inject('project','App\Project')


    @inject('department','App\Department')



    <?php


    $organizations = $organization->latest()->pluck('name', 'id')->toArray();


    $projects = $project->latest()->whereIn('id', auth()->user()->projects->pluck('id')->toArray())->pluck('name', 'id')->toArray();



    $departments = $department->latest()->pluck('name', 'id')->toArray();
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
        </div>
    </div>
    <div class="ibox ibox-primary">
        <div class="ibox-title">
            <h5>{{trans('main.employee_time_sheet') }}</h5>
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
                                'action'=>'Admin\EmployeeTimeSheetController@store',
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
                            <label class="control-label" style="margin-bottom: 35px;"
                                   for="attendance">{{trans('main.attendance')}}</label>

                            {{Form::select('attendance', [
                                'yes'=>trans('main.yes'),
                                'no'=>trans('main.no'),
                                'official_vacation_yes'=>trans('main.official_vacation_yes'),
                                'official_vacation_no'=>trans('main.official_vacation_no'),
                                'normal_vacation'=>trans('main.normal_vacation'),
                                'casual_vacation'=>trans('main.casual_vacation'),
                                ], null, [
                                "class" => "form-control select2 " ,
                                "id" => "attendance",
                                "placeholder" => trans('main.attendance')
                            ])}}
                            {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
                        </div>
                    </div>
                    <div class="col-sm-4 text-center">
                        <label for="">period 1</label>
                        <div class="col-sm-12">
                            <div class="col-sm-6">
                                <label class="control-label" for="from">{{trans('main.from')}}</label>
                                <div class="input-group clockpicker" data-autoclose="true">
                                    <input type="text" name="from1" class="form-control"
                                           placeholder="{{trans('main.from')}}" value="{{old('from1')}}">
                                    <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label" for="from">{{trans('main.to')}}</label>
                                <div class="input-group clockpicker" data-autoclose="true">
                                    <input type="text" name="to1" class="form-control"
                                           placeholder="{{trans('main.to')}}" value="{{old('to1')}}">
                                    <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-4 text-center">
                        <label for="">period 2</label>
                        <div class="col-sm-12">
                            <div class="col-sm-6">
                                <label class="control-label" for="from">{{trans('main.from')}}</label>
                                <div class="input-group clockpicker" data-autoclose="true">
                                    <input type="text" name="from2" class="form-control"
                                           placeholder="{{trans('main.from')}}" value="{{old('from2')}}">
                                    <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label" for="from">{{trans('main.to')}}</label>
                                <div class="input-group clockpicker" data-autoclose="true">
                                    <input type="text" name="to2" class="form-control"
                                           placeholder="{{trans('main.to')}}" value="{{old('to2')}}">
                                    <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label class="control-label" style="margin-bottom: 35px;" for="reward">{{trans('main.reward')}}</label>
                            {{Form::number('reward', null, [
                        "placeholder" => trans('main.reward'),
                        "class" => "form-control ",
                        "id" => 'reward' ])}}
                            <span class="help-block text-danger"><strong></strong></span>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label class="control-label" style="margin-bottom: 35px;" for="details">{{trans('main.details')}}</label>
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
                <div class="table-responsive">
                    <table class="data-table table table-bordered myTable">
                        <thead>
                        <th>{{trans('main.select')}}</th>
                        {{--                        <th>{{trans('main.transaction_no') }}</th>--}}
                        <th>{{trans('main.id') }}</th>
                        <th>{{trans('main.name') }}</th>
                        <th>{{trans('main.normal_vacation') }}</th>
                        <th>{{trans('main.casual_vacation') }}</th>
                        {{--                        <th>{{trans('main.contract_type') }}</th>--}}
                        {{--                        <th>{{trans('main.custody_transaction_no') }}</th>--}}
                        <th>{{trans('main.organization') }}</th>
                        <th>{{trans('main.project') }}</th>
                        <th>{{trans('main.labors_type') }}</th>


                        {{--<th class="text-center">{{trans('main.edit') }}</th>--}}
                        {{--<th class="text-center">{{trans('main.delete') }}</th>--}}
                        </thead>
                        <tbody>
                        @php $count = 1; @endphp
                        @foreach($rows as $row)
                            <?php
                            $iteration = $loop->iteration
                            ?>
                            <tr>
                                <td><input class="checkbox1" type="checkbox" value="{{$row->id}}" name="ids[]"></td>
                                {{--                                <td>{{$row->id}}</td>--}}
                                <td>{{$row->id}}</td>
                                <td>{{$row->name}}</td>
                                <td>{{$row->normal_vacation_no}}</td>
                                <td>{{$row->casual_vacation_no}}</td>


                                {{--                                <td>{{$row->safe_transaction_id ?? ''}}</td>--}}

                                <td>{{$row->organization->name ?? ''}}</td>
                                <td>{{$row->project->name ?? ''}}</td>
                                <td>{{$row->department->name ?? ''}}</td>

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

            })
//                .datepicker("setDate", today)
            ;
        </script>
    @endpush
@stop
