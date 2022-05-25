@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.employee_salary'),'url'=>'employee-salary'])
@stop
@section('content')
    @inject('organization','App\Organization')
    @inject('project','App\Project')


    @inject('department','App\Department')
    @inject('safe','App\Safe')


    <?php
    $safes = $safe->oldest()->pluck('name', 'id')->toArray();

    $organizations = $organization->latest()->pluck('name', 'id')->toArray();


    $projects = $project->latest()->whereIn('id', auth()->user()->projects->pluck('id')->toArray())->pluck('name', 'id')->toArray();



    $departments = $department->latest()->pluck('name', 'id')->toArray();
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
            <h5>{{trans('main.employee_salary') }}</h5>
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


            </div>
            <div class="row">
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
                                'action'=>'Admin\EmployeeSalaryController@store',
                                'id'=>'myForm',
                                'role'=>'form',
                                   'files'=>'true',
                                'method'=>'POST'
                                ])!!}
                <div class="row">
                    @include('partials.validation-errors')
                    <input type="hidden" name="start" value="{{request()->from}}">
                    <input type="hidden" name="end" value="{{request()->to}}">
                    <div class="col-md-6">

                        {!! Field::select('safe_id' , trans('main.safe'),$safes,trans('main.select_safe')) !!}
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
                        <tr>
                            {{--<th colspan="10"></th>--}}
                            <th rowspan="2">{{trans('main.select')}}</th>
                            {{--                        <th>{{trans('main.transaction_no') }}</th>--}}
                            <th rowspan="2">{{trans('main.id') }}</th>
                            <th rowspan="2">{{trans('main.name') }}</th>
                            <th rowspan="2">{{trans('main.job') }}</th>
                            <th rowspan="2">{{trans('main.days') }}</th>
                            <th rowspan="2">{{trans('main.current_salary_per_hours') }}</th>
                            <th rowspan="2">{{trans('main.total_regular_hours') }}</th>
                            <th rowspan="2">{{trans('main.total_regular') }}</th>
                            <th rowspan="2">{{trans('main.total_overtime_hours') }}</th>
                            <th rowspan="2">{{trans('main.total_overtime') }}</th>
                            <th rowspan="2">{{trans('main.total_salary_hours') }}</th>
                            <th rowspan="2">{{trans('main.total_salary') }}</th>
                            <th colspan="3" rowspan="1" class="text-center">{{trans('main.allowances')}}</th>
                            <th colspan="3" rowspan="1" class="text-center">{{trans('main.deductions')}}</th>

                            <th rowspan="2">{{trans('main.monthly_evaluations') }}</th>
                            <th rowspan="2">{{trans('main.loans') }}</th>
                            <th rowspan="2">{{trans('main.net') }}</th>
                            {{--                            <th colspan="3">{{trans('main.deductions')}}</th>--}}
                            {{--<th colspan="1"></th>--}}
                        </tr>
                        <tr>


                            {{--<th rowspan="1" colspan="3">{{trans('main.aa') }}</th>--}}
                            <th rowspan="1">{{trans('main.meals') }}</th>
                            <th rowspan="1">{{trans('main.communications') }}</th>
                            <th rowspan="1">{{trans('main.transports') }}</th>
                            <th>{{trans('main.penalties') }}</th>
                            <th>{{trans('main.taxes') }}</th>
                            <th>{{trans('main.insurance') }}</th>

                        </tr>


                        {{--$sum_net = 0;--}}
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
                                <td>{{$row->job->name}}</td>
                                <td>{{$row->employeeTimeSheet()->where('attendance','yes')->whereBetween('date', [request()->from, request()->to])->whereNull('accounting_id')->count()}}</td>
                                <td>{{$row->hourly_salary}}</td>
                                <td>{{$row->employeeTimeSheet()->where('attendance','yes')->whereBetween('date', [request()->from, request()->to])->whereNull('accounting_id')->sum('total_regular_minutes')/60}}</td>
                                <td>{{$row->employeeTimeSheet()->where('attendance','yes')->whereBetween('date', [request()->from, request()->to])->whereNull('accounting_id')->sum('total_regular')}}</td>
                                <td>{{$row->employeeTimeSheet()->where('attendance','yes')->whereBetween('date', [request()->from, request()->to])->whereNull('accounting_id')->sum('overtime_minutes')/60}}</td>
                                <td>{{$row->employeeTimeSheet()->where('attendance','yes')->whereBetween('date', [request()->from, request()->to])->whereNull('accounting_id')->sum('overtime')}}</td>
                                <td>{{$row->employeeTimeSheet()->where('attendance','yes')->whereBetween('date', [request()->from, request()->to])->whereNull('accounting_id')->sum('total_daily_minutes')/60}}</td>
                                <td>{{$row->employeeTimeSheet()->where('attendance','yes')->whereBetween('date', [request()->from, request()->to])->whereNull('accounting_id')->sum('total_daily')}}</td>
                                <td>{{$row->job->meals  }}</td>
                                <td>{{$row->job->communications}}</td>
                                <td>{{$row->job->transports}}</td>
                                <td>{{$row->job->penalties}}</td>
                                <td>{{$row->job->taxes}}</td>
                                <td>{{$row->job->insurance}}</td>
                                <td>{{$row->loans()->whereNull('accounting_id')->sum('amount')}}</td>
                                <td>{{$row->employeeMonthlyEvaluation()->whereBetween('date', [request()->from, request()->to])->whereNull('accounting_id')->sum('amount')}}</td>

                                <?php
                                $allowances = $row->job->meals + $row->job->communications + $row->job->transports;
                                $deductions = $row->job->penalties + $row->job->taxes + $row->job->insurance;
                                $total = $row->employeeTimeSheet()->where('attendance', 'yes')->whereBetween('date', [request()->from, request()->to])->whereNull('accounting_id')->sum('total_daily');
                                $net = $total + $allowances - $deductions;
                                //                                $sum_net += $net;
                                ?>
                                <td>{{$net }}</td>


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

            $(".datepicker2").datepicker({
                currentText: "{{trans('main.current_month')}}",
                closeText: "{{trans('main.select')}}",
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                changeDay: true,
                dateFormat: 'MM yy',
//                isRTL: true,
                onClose: function (dateText, inst) {
                    $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
                }

            });
        </script>
    @endpush
@stop

