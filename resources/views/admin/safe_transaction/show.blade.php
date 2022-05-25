@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.safe_transactions'),'url'=>'safe-transaction'])
@stop
@section('content')
    <!-- FILE: app/views/start.blade.php -->
    <div class="ibox-content m-b-sm border-bottom float-e-margins">

        <div class="row">

            @if($row->type=="cashout" and $row->status== "open")
                <form method="post" action="{{route('safe-transaction-change-status')}}" style="display: inline;">
                    {{csrf_field()}}
                    <button class="btn btn-primary btn-outline " type="submit" name="confirm" value="confirm"><i
                                class="fa fa-check"></i> {{trans('main.confirm')}}
                    </button>

                    <button class="btn btn-danger btn-outline " type="submit" name="action" value="decline"><i
                                class="fa fa-times"></i> {{trans('main.decline')}}
                    </button>
                    {{--<button type="submit" class="btn btn-primary btn-outline " name="action" value="update">Update</button>--}}
                    {{--<button type="submit" name="action" value="delete">Delete</button>--}}
                </form>
            @endif
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
                                    <h2>{{trans('main.details')}}</h2>
                                </div>
                                <dl class="dl-horizontal">
                                    {{--<dt>{{trans('main.working_status')}}:</dt>--}}
                                    {{--<dd><span class="label label-primary">{{$row->working_status_display}}</span></dd>--}}
                                </dl>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5">
                                <dl class="dl-horizontal">


                                    <dt>{{trans('main.transaction_no')}}:</dt>
                                    <dd> {{$row->id}}      </dd>
                                    <dt>{{trans('main.organization')}}:</dt>
                                    <dd> {{$row->organization->name ?? ''}}      </dd>


                                </dl>
                            </div>
                            <div class="col-lg-7" id="cluster_info">
                                <dl class="dl-horizontal">

                                    <dt>{{trans('main.amount')}}:</dt>
                                    <dd> {{$row->amount}}      </dd>
                                    <dt>{{trans('main.project')}}:</dt>
                                    <dd> {{$row->project->name ?? ''}}</dd>


                                </dl>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>


@stop