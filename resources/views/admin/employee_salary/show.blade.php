@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.employee_salaries'),'url'=>'employee-salary'])
@stop
@section('content')
    <!-- FILE: app/views/start.blade.php -->
    <div class="ibox-content m-b-sm border-bottom float-e-margins">

        <div class="row">
            <div class="pull-right">
                <a class="btn btn-outline btn-primary" target="_blank" href="{{url('admin/employee-salary-print/'.$row->id)}}"><i class="fa fa-print"></i>  {{trans('main.print')}}
                </a>




            </div>
            @include('partials.validation-errors')

            {{--@if($row->type=="cashin" and $row->payment_status=="waiting" )--}}


            {{--<form method="post" action="{{route('accounting-change-status')}}" style="display: inline;">--}}
            {{--{{csrf_field()}}--}}

            {{--<input type="hidden" name="id" value="{{$row->id}}">--}}
            {{--<button class="btn btn-primary btn-outline " type="submit" name="payment_status" value="confirmed"><i--}}
            {{--class="fa fa-check"></i> {{trans('main.confirm')}}--}}
            {{--</button>--}}

            {{--<button class="btn btn-danger btn-outline " type="submit" name="payment_status" value="cancel"><i--}}
            {{--class="fa fa-times"></i> {{trans('main.decline')}}--}}
            {{--</button>--}}
            {{--<button type="submit" class="btn btn-primary btn-outline " name="action" value="update">Update</button>--}}
            {{--<button type="submit" name="action" value="delete">Delete</button>--}}
            {{--</form>--}}


            {{--@endif--}}
            @can('managerAcceptDeclineEmployeeSalary')
                @if($row->type=="employeeSalary" and $row->manager_status=="waiting"  )


                    <form method="post" action="{{route('employee-salary-manager-change-status')}}"
                          style="display: inline;">
                        {{csrf_field()}}

                        <input type="hidden" name="id" value="{{$row->id}}">
                        <button class="btn btn-primary btn-outline " type="submit" name="manager_status" value="accept">
                            <i
                                    class="fa fa-check"></i> {{trans('main.manager_accept')}}
                        </button>

                        <button class="btn btn-danger btn-outline " type="submit" name="manager_status" value="decline">
                            <i
                                    class="fa fa-times"></i> {{trans('main.manager_decline')}}
                        </button>
                        {{--<button type="submit" class="btn btn-primary btn-outline " name="action" value="update">Update</button>--}}
                        {{--<button type="submit" name="action" value="delete">Delete</button>--}}
                    </form>


                @endif

            @endcan
            @can('safeAcceptDeclineEmployeeSalary')
                @if($row->type=="employeeSalary"  and $row->payment_status=="waiting" and $row->manager_status=="accept"  )


                    <form method="post" action="{{route('employee-salary-safe-change-status')}}"
                          style="display: inline;">
                        {{csrf_field()}}

                        <input type="hidden" name="id" value="{{$row->id}}">
                        <button class="btn btn-primary btn-outline " type="submit" name="payment_status"
                                value="confirmed"><i
                                    class="fa fa-check"></i> {{trans('main.safe_confirm')}}
                        </button>

                        <button class="btn btn-danger btn-outline " type="submit" name="payment_status" value="cancel">
                            <i
                                    class="fa fa-times"></i> {{trans('main.safe_decline')}}
                        </button>
                        {{--<button type="submit" class="btn btn-primary btn-outline " name="action" value="update">Update</button>--}}
                        {{--<button type="submit" name="action" value="delete">Delete</button>--}}
                    </form>


                @endif
            @endcan

            {{--@if(($row->type=="invoice"  or $row->type=="expense" ) and $row->payment_status=="waiting" and $row->manager_status=="accept"  )--}}


            {{--<form method="post" action="{{route('invoice-safe-change-status')}}" style="display: inline;">--}}
            {{--{{csrf_field()}}--}}

            {{--<input type="hidden" name="id" value="{{$row->id}}">--}}
            {{--<button class="btn btn-primary btn-outline " type="submit" name="payment_status" value="confirmed"><i--}}
            {{--class="fa fa-check"></i> {{trans('main.safe_confirm')}}--}}
            {{--</button>--}}

            {{--<button class="btn btn-danger btn-outline " type="submit" name="payment_status" value="cancel"><i--}}
            {{--class="fa fa-times"></i> {{trans('main.safe_decline')}}--}}
            {{--</button>--}}
            {{--<button type="submit" class="btn btn-primary btn-outline " name="action" value="update">Update</button>--}}
            {{--<button type="submit" name="action" value="delete">Delete</button>--}}
            {{--</form>--}}


            {{--@endif--}}

            {{--@if(($row->type=="invoice"  or $row->type=="expense" ) and $row->stock_status=="waiting" and $row->manager_status=="accept"  )--}}


            {{--<form method="post" action="{{route('invoice-stock-change-status')}}" style="display: inline;">--}}
            {{--{{csrf_field()}}--}}

            {{--<input type="hidden" name="id" value="{{$row->id}}">--}}
            {{--<button class="btn btn-primary btn-outline " type="submit" name="stock_status" value="confirmed"><i--}}
            {{--class="fa fa-check"></i> {{trans('main.stock_confirm')}}--}}
            {{--</button>--}}

            {{--<button class="btn btn-danger btn-outline " type="submit" name="stock_status" value="cancel"><i--}}
            {{--class="fa fa-times"></i> {{trans('main.stock_decline')}}--}}
            {{--</button>--}}
            {{--<button type="submit" class="btn btn-primary btn-outline " name="action" value="update">Update</button>--}}
            {{--<button type="submit" name="action" value="delete">Delete</button>--}}
            {{--</form>--}}


            {{--@endif--}}
            {{--<a class="btn btn-primary btn-outline " href="{{url('admin/safe-transaction-approve/'.$row->id)}}"><i--}}
            {{--class="fa fa-check"></i> {{trans('main.confirm')}}--}}
            {{--</a>--}}
            <div class="pull-left">
                {{--<a class="btn btn-outline btn-warning" target="_blank" href="{{url('admin/employee-print/'.$row->id)}}"><i--}}
                {{--class="fa fa-print"></i> {{trans('main.print_id_card')}}--}}
                {{--</a>--}}


            </div>

        </div>

    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content animated fadeInUp">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="m-b-md">
                                    {{--<a href="{{url('admin/employee/'.$row->id.'/edit')}}"--}}
                                    {{--class="btn btn-outline btn-primary  pull-right">{{trans('main.edit')}}</a>--}}
                                    <h2>{{trans('main.details')}} # {{$row->id}}</h2>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <dl class="dl-horizontal">
                                    <dt>{{trans('main.manager_status')}}:</dt>
                                    <dd><span class="label label-primary">{{$row->manager_status}}</span></dd>
                                </dl>
                            </div>
                            <div class="col-lg-7">
                                <dl class="dl-horizontal">
                                    <dt>{{trans('main.payment_status')}}:</dt>
                                    <dd><span class="label label-primary">{{$row->payment_status}}</span></dd>
                                </dl>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-5">
                                <dl class="dl-horizontal">


                                    {{--<dt>{{trans('main.transaction_no')}}:</dt>--}}
                                    {{--<dd> {{$row->id}}      </dd>--}}
                                    <dt>{{trans('main.date')}}:</dt>
                                    <td>{{\Carbon\Carbon::parse($row->date)->format('F Y')}}</td>
                                    <dt>{{trans('main.details')}}:</dt>
                                    <dd> {{$row->details}}      </dd>


                                </dl>
                            </div>
                            <div class="col-lg-7" id="cluster_info">
                                <dl class="dl-horizontal">

                                    <dt>{{trans('main.amount')}}:</dt>
                                    <dd> {{$row->amount}}      </dd>
                                    {{--<dt>{{trans('main.to')}}:</dt>--}}
                                    {{--<dd> {{$row->end}}      </dd>--}}
                                    <dt>{{trans('main.safe')}}:</dt>
                                    <dd> {{$row->safe->name ?? ''}}</dd>


                                </dl>
                            </div>
                        </div>
                        <div class="row">

                            @if($row->accountingEmployeeSalaryDetail()->count()>0)
                                <div class="table-responsive">
                                    <table class="data-table table table-bordered">
                                        <thead>
                                        <tr>
                                            {{--<th colspan="10"></th>--}}
                                            <th rowspan="2">#</th>

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
                                            <th colspan="3" rowspan="1"
                                                class="text-center">{{trans('main.allowances')}}</th>
                                            <th colspan="3" rowspan="1"
                                                class="text-center">{{trans('main.deductions')}}</th>

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

                                        </thead>
                                        <tbody>

                                        @foreach($row->accountingEmployeeSalaryDetail as $r)

                                            <tr>
                                                <td>{{ $loop->iteration}}</td>
                                                {{--                                <td>{{$row->id}}</td>--}}
                                                <td>{{$r->employee->id}}</td>
                                                <td>{{$r->employee->name}}</td>
                                                <td>{{$r->employee->job->name ?? ''}}</td>
                                                <td>{{$r->days}}</td>
                                                <td>{{number_format($r->hourly_salary,2)}}</td>
                                                <td>{{$r->total_regular_minutes/60}}</td>
                                                <td>{{number_format($r->total_regular,2)}}</td>
                                                <td>{{$r->overtime_minutes/60}}</td>
                                                <td>{{number_format($r->overtime,2)}}</td>
                                                <td>{{$r->total_daily_minutes/60}}</td>
                                                <td>{{number_format($r->total_daily,2)}}</td>
                                                <td>{{number_format($r->rewards,2)}}</td>
                                                <td>{{number_format($r->meals,2)}}</td>
                                                <td>{{number_format($r->communications,2)}}</td>
                                                <td>{{number_format($r->transports,2)}}</td>
                                                <td>{{number_format($r->penalties,2)}}</td>


                                                <td>{{number_format($r->taxes,2)}}</td>
                                                <td>{{number_format($r->insurance,2)}}</td>
                                                <td>{{number_format($r->monthly_evaluations,2)}}</td>
                                                <td>{{number_format($r->loans,2)}}</td>

                                                <td>{{number_format($r->net,2)}}</td>

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

                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td>{{trans('main.total')}}</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>{{$row->accountingEmployeeSalaryDetail()->sum('days')}}</td>
                                            <td>{{number_format($row->accountingEmployeeSalaryDetail()->sum('hourly_salary'),2)}}</td>
                                            <td>{{$row->accountingEmployeeSalaryDetail()->sum('total_regular_minutes')/60}}</td>
                                            <td>{{number_format($row->accountingEmployeeSalaryDetail()->sum('total_regular'),2)}}</td>
                                            <td>{{$row->accountingEmployeeSalaryDetail()->sum('overtime_minutes')/60}}</td>
                                            <td>{{number_format($row->accountingEmployeeSalaryDetail()->sum('overtime'),2)}}</td>
                                            <td>{{$row->accountingEmployeeSalaryDetail()->sum('total_daily_minutes')/60}}</td>
                                            <td>{{number_format($row->accountingEmployeeSalaryDetail()->sum('total_daily'),2)}}</td>
                                            <td>{{number_format($row->accountingEmployeeSalaryDetail()->sum('rewards'),2)}}</td>
                                            <td>{{number_format($row->accountingEmployeeSalaryDetail()->sum('meals'),2)}}</td>
                                            <td>{{number_format($row->accountingEmployeeSalaryDetail()->sum('communications'),2)}}</td>
                                            <td>{{number_format($row->accountingEmployeeSalaryDetail()->sum('transports'),2)}}</td>
                                            <td>{{number_format($row->accountingEmployeeSalaryDetail()->sum('penalties'),2)}}</td>
                                            <td>{{number_format($row->accountingEmployeeSalaryDetail()->sum('taxes'),2)}}</td>
                                            <td>{{number_format($row->accountingEmployeeSalaryDetail()->sum('insurance'),2)}}</td>
                                            <td>{{number_format($row->accountingEmployeeSalaryDetail()->sum('monthly_evaluations'),2)}}</td>
                                            {{--                                    <td>{{number_format($row->accountingEmployeeSalaryDetail()->sum('loans'),2)}}</td>--}}
                                            <td>{{number_format($row->accountingEmployeeSalaryDetail()->sum('net') + $row->accountingEmployeeSalaryDetail()->sum('loans'),2)}}</td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="text-center">
                                    {{--{!! $rows->appends(request()->except('page'))->links() !!}--}}
                                </div>
                            @else
                                <h2 class="text-center">{{trans('main.no_records') }}</h2>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>


@stop
