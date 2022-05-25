@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.worker_loans'),'url'=>'worker-loan'])
@stop
@section('content')
    <!-- FILE: app/views/start.blade.php -->
    <div class="ibox-content m-b-sm border-bottom float-e-margins">

        <div class="row">

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
            @can('managerAcceptDeclineWorkerLoan')
                @if($row->type=="workerLoan" and $row->manager_status=="waiting"  )


                    <form method="post" action="{{route('worker-loan-manager-change-status')}}"
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
            @can('safeAcceptDeclineWorkerLoan')
                @if($row->type=="workerLoan"  and $row->payment_status=="waiting" and $row->manager_status=="accept"  )


                    <form method="post" action="{{route('worker-loan-safe-change-status')}}" style="display: inline;">
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


                                    <dt>{{trans('main.worker')}}:</dt>
                                    <dd> {{$row->worker->name ?? ''}}      </dd>
                                    <dt>{{trans('main.date')}}:</dt>
                                    <dd> {{$row->date}}      </dd>
                                    <dt>{{trans('main.details')}}:</dt>
                                    <dd> {{$row->details}}      </dd>


                                </dl>
                            </div>
                            <div class="col-lg-7" id="cluster_info">
                                <dl class="dl-horizontal">

                                    <dt>{{trans('main.amount')}}:</dt>
                                    <dd> {{$row->amount}}      </dd>
                                    <dt>{{trans('main.safe')}}:</dt>
                                    <dd> {{$row->safe->name ?? ''}}</dd>


                                </dl>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>


@stop
