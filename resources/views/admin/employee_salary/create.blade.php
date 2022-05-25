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
                        <label for="date"> {{trans('main.date')}}</label>

                        {{--<input type="text" class="form-control">--}}
                        <div class="input-group date ">
                            {{Form::text('date', request()->date, [
                                            "placeholder" => trans('main.date'),
                                            "class" => "form-control datepicker2",

                                        ]) }}
                            {{--<input type="text" name="start_date" class="  form-control" id="filter-from"--}}
                            {{--value="" placeholder="من">--}}
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>


                    </div>
                </div>
                {{--<div class="col-sm-3">--}}
                {{--<div class="form-group"--}}
                {{--id="finish_date_wrap">--}}
                {{--<label for="filter-to">{{trans('main.to')}}</label>--}}

                {{--<input type="text" class="form-control">--}}
                {{--<div class="input-group date ">--}}
                {{--{{Form::text('to',  request()->to, [--}}
                {{--"placeholder" => trans('main.to'),--}}
                {{--"class" => "form-control",--}}
                {{--"id" => 'filter-to'--}}
                {{--]) }}--}}
                {{--<input type="text" name="finish_date" class="  form-control" id="filter-to"--}}
                {{--value="" placeholder="الى">--}}
                {{--<span class="input-group-addon"><i class="fa fa-calendar"></i></span>--}}
                {{--</div>--}}


                {{--</div>--}}
                {{--</div>--}}


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
                    {{--<input type="hidden" name="start" value="{{request()->from}}">--}}
                    <input type="hidden" name="date" value="{{request()->date}}">
                    <div class="col-md-6">

                        {!! Field::select('safe_id' , trans('main.safe'),$safes,trans('main.select_safe')) !!}
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
                            <th rowspan="2">{{trans('main.rewards') }}</th>
                            <th colspan="3" rowspan="1" class="text-center">{{trans('main.allowances')}}</th>
                            <th colspan="3" rowspan="1" class="text-center">{{trans('main.deductions')}}</th>

                            <th rowspan="2">{{trans('main.loans') }}</th>
                            <th rowspan="2">{{trans('main.monthly_evaluations') }}</th>
                            <th rowspan="2">{{trans('main.net') }}</th>
                            <th rowspan="2">{{trans('main.signature')}}</th>
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
                        <?php
                            $date =\Carbon\Carbon::parse(request()->date);
                            $days_sum = 0;
                            $total_regular_minutes_sum = 0;
                            $total_regular_sum = 0;
                            $overtime_minutes_sum = 0;
                            $overtime_sum = 0;
                            $total_daily_minutes_sum = 0;
                            $total_daily_sum = 0;
                            $reward_sum = 0;
                            $penalty_sum = 0;
                            $net_sum = 0;
                        ?>
                        @foreach($rows as $row)
                            <?php
                            $timesheet = $row->employeeTimeSheet()
                                ->where('attendance', '!=' , 'no')
                                ->whereMonth('date', $date)
                                ->whereYear('date', $date)
                                ->whereNull('accounting_id');
                            $days = $timesheet->count();
                            $total_regular_minutes = $timesheet->sum('total_regular_minutes')/60;
                            $total_regular =$timesheet->sum('total_regular');
                            $overtime_minutes = $timesheet->sum('overtime_minutes')/60;
                            $overtime = $timesheet->sum('overtime');
                            $total_daily_minutes = $timesheet->sum('total_daily_minutes')/60;
                            $total_daily = $timesheet->sum('total_daily');
                            $reward = $timesheet->sum('reward');
                            $penalty = $row->penalty()->whereMonth('date',$date)->whereYear('date', $date)->whereNull('accounting_id')->sum('amount');

                            $days_sum += $days;
                            $total_regular_minutes_sum += $total_regular_minutes;
                            $total_regular_sum += $total_regular;
                            $overtime_minutes_sum += $overtime_minutes;
                            $overtime_sum += $overtime;
                            $total_daily_minutes_sum += $total_daily_minutes;
                            $total_daily_sum += $total_daily;
                            $reward_sum += $reward;
                            $penalty_sum += $penalty;
                            ?>
                            <tr>
                                <td><input class="checkbox1" type="checkbox" value="{{$row->id}}" name="ids[]"></td>
                                {{--                                <td>{{$row->id}}</td>--}}
                                <td>{{$row->id}}</td>
                                <td>{{$row->name}}</td>
                                <td>{{$row->job->name}}</td>
                                <td>{{$days}}</td>
                                <td>{{number_format($row->hourly_salary,2)}}</td>
                                <td>{{$total_regular_minutes}}</td>
                                <td>{{number_format($row->total_regular,2)}}</td>
                                <td>{{$overtime_minutes}}</td>
                                <td>{{number_format($row->overtime,2)}}</td>
                                <td>{{$total_daily_minutes}}</td>
                                <td>{{number_format($row->total_daily,2)}}</td>
                                <td>{{number_format($reward,2)}}</td>
                                <td>{{number_format($row->meals,2)}}</td>
                                <td>{{number_format($row->communications,2)}}</td>
                                <td>{{number_format($row->transports,2)}}</td>
                                <td>{{number_format($penalty,2)}}</td>
                                <td>{{number_format($row->taxes,2)}}</td>
                                <td>{{number_format($row->insurance,2)}}</td>

                                <td>
                                    <?php
                                        $loans_input = $row->loans()->whereMonth('date','<=',$date)->whereNull('accounting_id')->sum('amount')
                                    ?>
                                    <input type="number" max="{{$loans_input}}" value="{{$loans_input}}" name="loans[{{$row->id}}]">
                                </td>
                                <td>{{$row->employeeMonthlyEvaluation()->whereMonth('date',$date)->whereYear('date', $date)->whereNull('accounting_id')->sum('amount')}}  </td>

                                <?php
                                $penalty = $row->penalty()->whereMonth('date', $date)->whereYear('date', $date)->whereNull('accounting_id')->sum('amount');
                                $allowances = $row->meals + $row->communications + $row->transports;
                                $deductions = $penalty + $row->taxes + $row->insurance;

                                $total = $row->employeeTimeSheet()->where('attendance','!=', 'no')->whereMonth('date', $date)->whereYear('date', $date)->whereNull('accounting_id')->sum('total_daily');
                                $rewards = $row->employeeTimeSheet()->where('attendance','!=', 'no')->whereMonth('date', $date)->whereYear('date', $date)->whereNull('accounting_id')->sum('reward');

                                $loans = $row->loans()->whereMonth('date','<=',$date)->whereNull('accounting_id')->sum('amount');
                                $monthly_evaluation = $row->employeeMonthlyEvaluation()->whereMonth('date', $date)->whereYear('date', $date)->whereNull('accounting_id')->sum('amount');

                                $net = $total + $rewards + $allowances - $deductions- $loans + $monthly_evaluation;
                                $net_sum += $net;
                                ?>


                                {{--<td>{{$total }}</td>--}}
                                {{--<td>{{$allowances }}</td>--}}
                                {{--<td>{{$deductions }}</td>--}}
                                <td>{{number_format($net,2) }}</td>
                                <td></td>


                            </tr>

                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>{{trans('main.total')}}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{$days_sum}}</td>
                                <td>{{$rows->sum('hourly_salary')}}</td>
                                <td>{{$total_regular_minutes_sum}}</td>
                                <td>{{$total_regular_sum}}</td>
                                <td>{{$overtime_minutes_sum}}</td>
                                <td>{{$overtime_sum}}</td>
                                <td>{{$total_daily_minutes_sum}}</td>
                                <td>{{$total_daily_sum}}</td>
                                <td>{{$reward_sum}}</td>
                                <td>{{$rows->sum('meals')}}</td>
                                <td>{{$rows->sum('communications')}}</td>
                                <td>{{$rows->sum('transports')}}</td>
                                <td>{{$penalty_sum}}</td>
                                <td>{{$rows->sum('taxes')}}</td>
                                <td>{{$rows->sum('insurance')}}</td>
                                <td></td>
                                <td></td>
                                <td>{{$net_sum}}</td>
                            </tr>
                        </tfoot>

                    </table>
                </div>
{{--                <div class="text-center">--}}
{{--                    {!! $rows->appends(request()->except('page'))->links() !!}--}}
{{--                </div>--}}

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

