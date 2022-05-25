@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.payments'),'url'=>'payment'])
@stop
@section('content')
    <!-- FILE: app/views/start.blade.php -->
    <div class="ibox-content m-b-sm border-bottom float-e-margins">

        <div class="row">

            @include('partials.validation-errors')

            @if($row->type=="cashout"   or $row->type=="custody")

                @if($row->payment_status=="review" )

                    @can('acceptPayment')

                        <form method="post" action="{{route('payment-accept')}}" style="display: inline;">
                            {{csrf_field()}}

                            <input type="hidden" name="id" value="{{$row->id}}">
                            <button class="btn btn-primary btn-outline " type="submit" name="payment_status"
                                    value="waiting"><i
                                        class="fa fa-check"></i> {{trans('main.confirm')}}
                            </button>
                        </form>
                    @endcan
                    @can('declinePayment')

                        <form method="post" action="{{route('payment-decline')}}" style="display: inline;">
                            {{csrf_field()}}

                            <input type="hidden" name="id" value="{{$row->id}}">
                            <button class="btn btn-danger btn-outline " type="submit" name="payment_status"
                                    value="cancel">
                                <i
                                        class="fa fa-times"></i> {{trans('main.decline')}}
                            </button>
                            {{--<button type="submit" class="btn btn-primary btn-outline " name="action" value="update">Update</button>--}}
                            {{--<button type="submit" name="action" value="delete">Delete</button>--}}
                        </form>
                    @endcan
                @elseif($row->payment_status=="waiting")

                    @can('payPayment')

                        <form method="post" action="{{route('cash-out-pay')}}" style="display: inline;">
                            {{csrf_field()}}
                            <input type="hidden" name="id" value="{{$row->id}}">
                            <button class="btn btn-primary btn-outline " type="submit" name="pay" value="pay"><i
                                        class="fa fa-check"></i> {{trans('main.pay')}}
                            </button>

                            {{--<button class="btn btn-danger btn-outline " type="submit" name="action" value="decline"><i--}}
                            {{--class="fa fa-times"></i> {{trans('main.decline')}}--}}
                            {{--</button>--}}
                            {{--<button type="submit" class="btn btn-primary btn-outline " name="action" value="update">Update</button>--}}
                            {{--<button type="submit" name="action" value="delete">Delete</button>--}}
                        </form>
                    @endcan
                @endif
            @endif
            {{--@if($row->type=="custody" )--}}
                {{--@if($row->payment_status=="review" )--}}
                    {{--@can('acceptPayment')--}}
                        {{--<form method="post" action="{{route('payment-custody-accept')}}" style="display: inline;">--}}
                            {{--{{csrf_field()}}--}}

                            {{--<input type="hidden" name="id" value="{{$row->id}}">--}}
                            {{--<button class="btn btn-primary btn-outline " type="submit" name="payment_status"--}}
                                    {{--value="waiting"><i--}}
                                        {{--class="fa fa-check"></i> {{trans('main.confirm')}}--}}
                            {{--</button>--}}
                        {{--</form>--}}
                    {{--@endcan--}}
                    {{--@can('declinePayment')--}}

                        {{--<form method="post" action="{{route('payment-custody-decline')}}" style="display: inline;">--}}
                            {{--{{csrf_field()}}--}}

                            {{--<input type="hidden" name="id" value="{{$row->id}}">--}}
                            {{--<button class="btn btn-danger btn-outline " type="submit" name="payment_status"--}}
                                    {{--value="cancel">--}}
                                {{--<i--}}
                                        {{--class="fa fa-times"></i> {{trans('main.decline')}}--}}
                            {{--</button>--}}
                            {{--<button type="submit" class="btn btn-primary btn-outline " name="action" value="update">Update</button>--}}
                            {{--<button type="submit" name="action" value="delete">Delete</button>--}}
                        {{--</form>--}}
                    {{--@endcan--}}
                {{--@elseif($row->payment_status=="waiting")--}}

                    {{--@can('payPayment')--}}

                        {{--<form method="post" action="{{route('custody-pay')}}" style="display: inline;">--}}
                            {{--{{csrf_field()}}--}}
                            {{--<input type="hidden" name="id" value="{{$row->id}}">--}}
                            {{--<button class="btn btn-primary btn-outline " type="submit" name="pay" value="pay"><i--}}
                                        {{--class="fa fa-check"></i> {{trans('main.pay')}}--}}
                            {{--</button>--}}

                            {{--<button class="btn btn-danger btn-outline " type="submit" name="action" value="decline"><i--}}
                            {{--class="fa fa-times"></i> {{trans('main.decline')}}--}}
                            {{--</button>--}}
                            {{--<button type="submit" class="btn btn-primary btn-outline " name="action" value="update">Update</button>--}}
                            {{--<button type="submit" name="action" value="delete">Delete</button>--}}
                        {{--</form>--}}
                    {{--@endcan--}}
                {{--@endif--}}
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
                                    <h2>{{trans('main.details')}}</h2>
                                </div>
                                <dl class="dl-horizontal">
                                    <dt>{{trans('main.payment_status')}}:</dt>
                                    <dd><span class="label label-primary">{{$row->payment_status}}</span></dd>
                                    <dt>{{trans('main.type')}}:</dt>
                                    <dd>{{$row->type}}</dd>
                                </dl>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5">
                                <dl class="dl-horizontal">

                                    <dt>{{trans('main.date')}}:</dt>
                                    <dd>{{$row->date}}</dd>
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
                                    <dt>{{trans('main.employee')}}:</dt>
                                    <dd> {{$row->employee->name ?? ''}}</dd>


                                </dl>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">

                    <div class="ibox-content">

                        <h2>{{trans('main.documents')}}</h2>


                        <div class="lightBoxGallery">

                            @foreach($row->images as $image)
                                <a href="{{url($image->image)}}" title="Tlg" data-gallery=""><img
                                            src="{{url($image->image_thumb)}}"></a>
                        @endforeach
                        <!-- The Gallery as lightbox dialog, should be a child element of the document body -->
                            <div id="blueimp-gallery" class="blueimp-gallery">
                                <div class="slides"></div>
                                <h3 class="title"></h3>
                                <a class="prev">‹</a>
                                <a class="next">›</a>
                                <a class="close">×</a>
                                <a class="play-pause"></a>
                                <ol class="indicator"></ol>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
@stop
