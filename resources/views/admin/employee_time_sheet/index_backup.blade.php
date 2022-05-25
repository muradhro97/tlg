@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.employee_time_sheet'),'url'=>'employee-time-sheet'])
@stop
@section('content')
    @inject('organization','App\Organization')
    @inject('project','App\Project')


    @inject('laborsDepartment','App\LaborsDepartment')



    <?php


    $organizations = $organization->latest()->pluck('name', 'id')->toArray();


    $projects = $project->latest()->pluck('name', 'id')->toArray();



    $laborsDepartments = $laborsDepartment->latest()->pluck('name', 'id')->toArray();
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
                        {{Form::select('project_id', $projects, null, [
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
                        {{Form::select('organization_id', $organizations, null, [
                            "class" => "form-control select2 " ,
                            "id" => "organization_id",
                            "placeholder" => trans('main.organization')
                        ])}}
                        {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="department_id">{{trans('main.labors_type')}}</label>
                        {{Form::select('department_id', $laborsDepartments, null, [
                            "class" => "form-control select2 " ,
                            "id" => "department_id",
                            "placeholder" => trans('main.labors_type')
                        ])}}
                        {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="date">{{trans('main.date')}}</label>
                        <div class="input-group date">

                            {!! Form::text('date',request()->date ?? \Carbon\Carbon::today()->format('Y-m-d'),[
                                'class' => 'form-control datepicker',
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
                            <label class="control-label" for="attendance">{{trans('main.attendance')}}</label>
                            {{Form::select('attendance', ['yes'=>trans('main.yes'),'no'=>trans('main.no')], null, [
                                "class" => "form-control select2 " ,
                                "id" => "attendance",
                                "placeholder" => trans('main.attendance')
                            ])}}
                            {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
                        </div>
                    </div>
                    <div class="col-sm-2 text-center">
                        <label for="">period 1</label>
                        <div class="col-sm-12">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" for="from">{{trans('main.from')}}</label>
                                    {{Form::text('from1', null, [
                                "placeholder" => trans('main.from'),
                                "class" => "form-control numberonly",
                                "id" => 'from' ])}}
                                    <span class="help-block text-danger"><strong></strong></span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" for="from">{{trans('main.to')}}</label>
                                    {{Form::text('to1', null, [
                                "placeholder" => trans('main.to'),
                                "class" => "form-control numberonly",
                                "id" => 'to1' ])}}
                                    <span class="help-block text-danger"><strong></strong></span>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-2 text-center">
                        <label for="">period 2</label>
                        <div class="col-sm-12">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" for="from">{{trans('main.from')}}</label>
                                    {{Form::text('from2', null, [
                                "placeholder" => trans('main.from'),
                                "class" => "form-control numberonly",
                                "id" => 'from' ])}}
                                    <span class="help-block text-danger"><strong></strong></span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" for="from">{{trans('main.to')}}</label>
                                    {{Form::text('to2', null, [
                                "placeholder" => trans('main.to'),
                                "class" => "form-control numberonly",
                                "id" => 'to1' ])}}
                                    <span class="help-block text-danger"><strong></strong></span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label class="control-label" for="deduction_hrs">{{trans('main.total_regular_hrs')}}</label>
                            {{Form::text('total_regular_hrs', null, [
                        "placeholder" => trans('main.total_regular_hrs'),
                        "class" => "form-control numberonly",
                        "id" => 'total_regular_hrs' ])}}
                            <span class="help-block text-danger"><strong></strong></span>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label class="control-label"
                                   for="total_overtime_hrs">{{trans('main.total_overtime_hrs')}}</label>
                            {{Form::text('total_overtime_hrs', null, [
                        "placeholder" => trans('main.deduction_value'),
                        "class" => "form-control numberonly",
                        "id" => 'total_overtime_hrs' ])}}
                            <span class="help-block text-danger"><strong></strong></span>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label class="control-label" for="safety">{{trans('main.total_daily_hrs')}}</label>
                            {{Form::text('total_daily_hrs', null, [
                        "placeholder" => trans('main.total_daily_hrs'),
                        "class" => "form-control numberonly",
                        "id" => 'total_daily_hrs' ])}}
                            <span class="help-block text-danger"><strong></strong></span>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-2 ">
                        <div class="form-group">
                            <label for="">&nbsp;</label>
                            <button type="submit"
                                    class="btn btn-flat  btn-primary btn-md">{{trans('main.save') }}</button>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <br>



                <div class="row">
                    <div class="col-md-4">
                        <input type="checkbox" id="select_all">
                        <label for="select_all">  {{trans('main.select_all')}} </label>


                    </div>

                </div>
                <div class="table-responsive">
                    <table class="data-table table table-bordered">
                        <thead>
                        <th>{{trans('main.select')}}</th>
                        {{--                        <th>{{trans('main.transaction_no') }}</th>--}}
                        <th>{{trans('main.id') }}</th>
                        <th>{{trans('main.name') }}</th>
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
                            $iteration = $loop->iteration + (($rows->currentPage() - 1) * $rows->perPage())
                            ?>
                            <tr>
                                <td><input type="checkbox" value="{{$row->id}}" name="ids[]"></td>
                                {{--                                <td>{{$row->id}}</td>--}}
                                <td>{{$row->id}}</td>
                                <td>{{$row->name}}</td>


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
                <div class="text-center">
                    {!! $rows->appends(request()->except('page'))->links() !!}
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


            $(".buy_date").datepicker({
                // dateFormat: 'yy-mm-dd'
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                // setDate: currentDate,
                // regional: "ar" ,
                // yearRange: “c-70:c+10”,
//                isRTL: true,
                changeYear: true,

            }).datepicker("setDate", today);
        </script>
    @endpush
@stop