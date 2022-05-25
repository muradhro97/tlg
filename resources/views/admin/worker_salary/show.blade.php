@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.worker_salaries'),'url'=>'worker-salary'])
@stop
@section('content')
    <!-- FILE: app/views/start.blade.php -->
    <div class="ibox-content m-b-sm border-bottom float-e-margins">

        <div class="row">
            <div class="pull-right">
                <a class="btn btn-outline btn-primary" target="_blank" href="{{url('admin/worker-salary-print/'.$row->id)}}"><i class="fa fa-print"></i>  {{trans('main.print')}}
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
            @can('managerAcceptDeclineWorkerSalary')
                @if($row->type=="workerSalary" and $row->manager_status=="waiting"  )


                    <form method="post" action="{{route('worker-salary-manager-change-status')}}"
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
            @can('safeAcceptDeclineWorkerSalary')
                @if($row->type=="workerSalary"  and $row->payment_status=="waiting" and $row->manager_status=="accept"  )


                    <form method="post" action="{{route('worker-salary-safe-change-status')}}" style="display: inline;">
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


                                    <dt>{{trans('main.safe')}}:</dt>
                                    <dd> {{$row->safe->name ?? ''}}</dd>
                                    <dt>{{trans('main.from')}}:</dt>
                                    <dd> {{$row->start}}      </dd>
                                    <dt>{{trans('main.details')}}:</dt>
                                    <dd> {{$row->details}}      </dd>


                                </dl>
                            </div>
                            <div class="col-lg-7" id="cluster_info">
                                <dl class="dl-horizontal">

                                    <dt>{{trans('main.amount')}}:</dt>
                                    <dd> {{$row->amount}}      </dd>
                                    <dt>{{trans('main.to')}}:</dt>
                                    <dd> {{$row->end}}      </dd>



                                </dl>
                            </div>
                        </div>
                        <div class="row">

                            @if($row->accountingWorkerSalaryDetail()->count()>0)
                                <div class="table-responsive">
                                    <table class="data-table table table-bordered">
                                        <thead>
                                        <th>#</th>
                                        <th>{{trans('main.id') }}</th>
                                        <th>{{trans('main.name') }}</th>
                                        {{--                        <th>{{trans('main.contract_type') }}</th>--}}
                                        {{--                        <th>{{trans('main.custody_transaction_no') }}</th>--}}
                                        <th>{{trans('main.days') }}</th>
                                        <th>{{trans('main.current_daily_salary') }}</th>
                                        <th>{{trans('main.daily_salary') }}</th>
                                        <th>{{trans('main.overtime') }}({{trans('main.hours')}})</th>
                                        <th>{{trans('main.current_hourly_salary') }}</th>
                                        <th>{{trans('main.additions') }}</th>
                                        <th>{{trans('main.deduction_hrs') }}</th>
                                        <th>{{trans('main.deduction_value') }}</th>
                                        <th>{{trans('main.safety') }}</th>
                                        <th>{{trans('main.discounts') }}</th>
                                        <th>{{trans('main.total') }}</th>
                                        <th>{{trans('main.loans') }}</th>
                                        <th>{{trans('main.taxes') }}</th>
                                        <th>{{trans('main.insurance') }}</th>
                                        <th>{{trans('main.net') }}</th>


                                        </thead>
                                        <tbody>

                                        @foreach($row->accountingWorkerSalaryDetail as $r)

                                            <tr>
                                                <td>{{ $loop->iteration}}</td>
                                                {{--                                <td>{{$row->id}}</td>--}}
                                                <td>{{$r->worker->id}}</td>
                                                <td>{{$r->worker->name}}</td>
                                                <td>{{$r->days}}</td>
                                                <td>{{number_format($r->worker->job->daily_salary ?? 0,2)}}</td>
                                                <td>{{number_format($r->daily_salary,2)}}</td>
                                                <td>{{$r->overtime}}</td>
                                                <td>{{number_format($r->worker->job->hourly_salary ?? 0,2)}}</td>
                                                <td>{{number_format($r->additions,2)}}</td>
                                                <td>{{$r->deduction_hrs}}</td>
                                                <td>{{number_format($r->deduction_value,2)}}</td>
                                                <td>{{$r->safety}}</td>
                                                <td>{{number_format($r->discounts,2)}}</td>
                                                <td>{{number_format($r->total,2)}}</td>
                                                <td>{{number_format($r->loans,2)}}</td>
                                                <td>{{number_format($r->taxes,2)}}</td>
                                                <td>{{number_format($r->insurance,2)}}</td>
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
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td>TOTAL</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>{{number_format($row->accountingWorkerSalaryDetail->sum('daily_salary'),2)}}</td>
                                            <td>{{number_format($row->accountingWorkerSalaryDetail->sum('overtime'),2)}}</td>
                                            <td></td>
                                            <td>{{number_format($row->accountingWorkerSalaryDetail->sum('additions'),2)}}</td>
                                            <td>{{number_format($row->accountingWorkerSalaryDetail->sum('deduction_hrs'),2)}}</td>
                                            <td>{{number_format($row->accountingWorkerSalaryDetail->sum('deduction_value'),2)}}</td>
                                            <td>{{number_format($row->accountingWorkerSalaryDetail->sum('safety'),2)}}</td>
                                            <td>{{number_format($row->accountingWorkerSalaryDetail->sum('discounts'),2)}}</td>
                                            <td>{{number_format($row->accountingWorkerSalaryDetail->sum('total'),2)}}</td>
                                            <td>{{number_format($row->accountingWorkerSalaryDetail->sum('loans'),2)}}</td>
                                            <td>{{number_format($row->accountingWorkerSalaryDetail->sum('taxes'),2)}}</td>
                                            <td>{{number_format($row->accountingWorkerSalaryDetail->sum('insurance'),2)}}</td>
                                            <td>{{number_format($row->accountingWorkerSalaryDetail->sum('net'),2)}}</td>
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
