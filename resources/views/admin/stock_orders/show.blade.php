@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.stock_orders'),'url'=>'stock-order'])
@stop
@section('content')
    <!-- FILE: app/views/start.blade.php -->
    <div class="ibox-content m-b-sm border-bottom float-e-margins">

        <div class="row">

            @include('partials.validation-errors')

            @if($row->status=="waiting" )
                @can('acceptStockOrder')
                    <form method="post" action="{{route('stock-accept')}}" style="display: inline;">
                        {{csrf_field()}}

                        <input type="hidden" name="id" value="{{$row->id}}">
                        <button class="btn btn-primary btn-outline " type="submit" name="status" value="accept"><i
                                    class="fa fa-check"></i> {{trans('main.accept')}}
                        </button>
                    </form>
                @endcan
                @can('declineStockOrder')
                    <form method="post" action="{{route('stock-decline')}}" style="display: inline;">
                        {{csrf_field()}}

                        <input type="hidden" name="id" value="{{$row->id}}">
                        <button class="btn btn-danger btn-outline " type="submit" name="status" value="cancel"><i
                                    class="fa fa-times"></i> {{trans('main.decline')}}
                        </button>
                        {{--<button type="submit" class="btn btn-primary btn-outline " name="action" value="update">Update</button>--}}
                        {{--<button type="submit" name="action" value="delete">Delete</button>--}}
                    </form>
                @endcan
            @elseif($row->status=="accept")


                @can('approveStockOrder')
                    <form method="post" action="{{route('stock-approve')}}" style="display: inline;">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{$row->id}}">
                        <input type="hidden" name="type" value="{{$row->type}}">
                        <button class="btn btn-primary btn-outline " type="submit" name="approve" value="approve"><i
                                    class="fa fa-check"></i> {{trans('main.approve')}}
                        </button>

                        {{--<button class="btn btn-danger btn-outline " type="submit" name="action" value="decline"><i--}}
                        {{--class="fa fa-times"></i> {{trans('main.decline')}}--}}
                        {{--</button>--}}
                        {{--<button type="submit" class="btn btn-primary btn-outline " name="action" value="update">Update</button>--}}
                        {{--<button type="submit" name="action" value="delete">Delete</button>--}}
                    </form>
                @endcan
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
                                    <dt>{{trans('main.status')}}:</dt>
                                    <dd><span class="label label-primary">{{$row->status}}</span></dd>
                                </dl>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5">
                                <dl class="dl-horizontal">


                                    <dt>{{trans('main.id')}}:</dt>
                                    <dd> {{$row->id}}      </dd>
                                    <dt>{{trans('main.date')}}:</dt>
                                    <dd> {{$row->date}}      </dd>
                                    <dt>{{trans('main.employee')}}:</dt>
                                    <dd> {{$row->employee->name ?? '---'}}      </dd>
                                    <dt>{{trans('main.worker')}}:</dt>
                                    <dd> {{$row->worker->name ?? '---'}}      </dd>
                                    <dt>{{trans('main.custody_type')}}:</dt>
                                    <dd> {{$row->custody_type}}      </dd>


                                </dl>
                            </div>
                            <div class="col-lg-7" id="cluster_info">
                                <dl class="dl-horizontal">

                                    <dt>{{trans('main.total')}}:</dt>
                                    <dd> {{$row->total}}      </dd>
                                    <dt>{{trans('main.stock_type')}}:</dt>
                                    <dd> {{$row->stockType->name ?? ''}}</dd>
                                    <dt>{{trans('main.approved_by')}}:</dt>
                                    <dd> {{$row->approvedBy->name ?? ''}}      </dd>
                                    <dt>{{trans('main.type')}}:</dt>
                                    <dd> {{$row->type}}      </dd>


                                </dl>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">


                                @if($row->stockDetails->count()>0)
                                    <div class="table-responsive">
                                        <table class="data-table table table-bordered">
                                            <thead>
                                            <th>#</th>
                                            <th>{{trans('main.item') }}</th>
                                            <th>{{trans('main.price') }}</th>
                                            <th>{{trans('main.quantity') }}</th>
                                            <th>{{trans('main.size') }}</th>
                                            <th>{{trans('main.color') }}</th>
                                            <th>{{trans('main.total') }}</th>
                                            <th>{{trans('main.net') }}</th>


                                            {{--<th class="text-center">{{trans('main.edit') }}</th>--}}
                                            {{--<th class="text-center">{{trans('main.delete') }}</th>--}}
                                            </thead>
                                            <tbody>

                                            @foreach($row->stockDetails as $r)

                                                <tr>
                                                    <td>{{$loop->iteration}}</td>

                                                    <td>{{$r->item->name ?? ''}}</td>
                                                    <td>{{$r->price}}</td>
                                                    <td>{{$r->quantity}}</td>
                                                    <td>{{$r->size?? '---'}}</td>
                                                    <td>{{$r->color?? '---'}}</td>
                                                    <td>{{$r->price * $r->quantity}}</td>
                                                    <td>{{$r->net}}</td>


                                                </tr>

                                            @endforeach
                                            </tbody>
                                        </table>
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

    </div>


@stop
