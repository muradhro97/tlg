@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.invoices'),'url'=>'invoice'])
@stop
@section('content')
    <!-- FILE: app/views/start.blade.php -->
    <div class="ibox-content m-b-sm border-bottom float-e-margins">

        <div class="row">
            <div class="pull-right">
                <a class="btn btn-outline btn-primary" target="_blank" href="{{url('admin/invoice-print/'.$row->id)}}"><i class="fa fa-print"></i>  {{trans('main.print')}}
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
            @can('managerAcceptDeclineInvoice')
                @if(($row->type=="invoice"  or $row->type=="expense" ) and $row->manager_status=="waiting"  )


                    <form method="post" action="{{route('invoice-manager-change-status')}}" style="display: inline;">
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
            @can('safeAcceptDeclineInvoice')
                @if(($row->type=="invoice"  or $row->type=="expense" ) and $row->payment_status=="waiting" and $row->manager_status=="accept"  )


                    <form method="post" action="{{route('invoice-safe-change-status')}}" style="display: inline;">
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

            @can('stockAcceptDeclineInvoice')
                @if(($row->type=="invoice"  ) and $row->stock_status=="waiting" and $row->manager_status=="accept"  )


                    <form method="post" action="{{route('stock-accounting-change-status')}}" style="display: inline;">
                        {{csrf_field()}}

                        <input type="hidden" name="id" value="{{$row->id}}">
                        <button class="btn btn-primary btn-outline " type="submit" name="stock_status"
                                value="confirmed"><i
                                    class="fa fa-check"></i> {{trans('main.stock_confirm')}}
                        </button>

                        <button class="btn btn-danger btn-outline " type="submit" name="stock_status" value="cancel"><i
                                    class="fa fa-times"></i> {{trans('main.stock_decline')}}
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
                            @if($row->type=="invoice")
                                <div class="col-lg-5">
                                    <dl class="dl-horizontal">
                                        <dt>{{trans('main.stock_status')}}:</dt>
                                        <dd><span class="label label-primary">{{$row->stock_status}}</span></dd>
                                    </dl>
                                </div>
                            @endif
                            <div class="col-lg-7">
                                <dl class="dl-horizontal">
                                    <dt>{{trans('main.type')}}:</dt>
                                    <dd><span class="label label-primary">{{$row->type}}</span></dd>
                                </dl>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-5">
                                <dl class="dl-horizontal">


                                    {{--<dt>{{trans('main.id')}}:</dt>--}}
                                    {{--<dd> {{$row->id}}      </dd>--}}
                                    <dt>{{trans('main.date')}}:</dt>
                                    <dd> {{$row->date}}      </dd>

                                    <dt>{{trans('main.submitted_by')}}:</dt>
                                    <dd> {{$row->employee->name ?? ''}}    {{$row->is_on_custody? '| On Employee Custody' : ''}} </dd>
                                    @if($row->type=="invoice")
                                        <dt>{{trans('main.organization')}}:</dt>
                                        <dd> {{$row->organization->name ?? ''}}      </dd>
                                        <dt>{{trans('main.project')}}:</dt>
                                        <dd> {{$row->project->name ?? ''}}      </dd>
                                    @endif

                                </dl>
                            </div>
                            <div class="col-lg-7" id="cluster_info">
                                <dl class="dl-horizontal">

                                    <dt>{{trans('main.amount')}}:</dt>
                                    <dd> {{$row->amount}}      </dd>

                                    <dt>{{trans('main.safe')}}:</dt>
                                    <dd> {{$row->safe->name ?? ''}}</dd>
                                    @if($row->type=="invoice")
                                        <dt>{{trans('main.project')}}:</dt>
                                        <dd> {{$row->project->name ?? ''}}</dd>
                                        <dt>{{trans('main.labors_department')}}:</dt>
                                        <dd> {{$row->laborsDepartment->name ?? ''}}</dd>
                                    @endif
                                </dl>
                            </div>
                        </div>
                        <div class="row">
                            @if($row->type=="invoice")
                                <div class="table-responsive">
                                    <table class="data-table table table-bordered">
                                        <thead>
                                        {{--<th>#</th>--}}
                                        <th>{{trans('main.item_name')}}</th>
                                        <th>{{trans('main.quantity')}}</th>
                                        <th>{{trans('main.price')}}</th>
                                        <th>{{trans('main.total')}}</th>



                                        </thead>
                                        <tbody class="">
                                        @foreach($row->accountingDetails as  $inv)
                                            <tr>

                                                <td>{{$inv->item->name ?? ''}}</td>
                                                <td>{{$inv->quantity}}</td>
                                                <td>{{$inv->price}}</td>
                                                <td>{{ number_format($inv->price * $inv->quantity,4, '.', '')}}</td>

                                            </tr>
                                        @endforeach
                                        <tr>

                                        </tr>

                                        <tr style=" border: 2px dashed #3c8dbc;">
                                            <td colspan="3">Net</td>
                                            <td colspan="2" class="total">{{$row->amount}}</td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            @elseif($row->type=="expense")
                                <div class="table-responsive">
                                    <table class="data-table table table-bordered">
                                        <thead>
                                        {{--<th>#</th>--}}
                                        <th>{{trans('main.expense_item')}}</th>
                                        <th>{{trans('main.item_name')}}</th>
                                        <th>{{trans('main.quantity')}}</th>
                                        <th>{{trans('main.price')}}</th>
                                        <th>{{trans('main.total')}}</th>


                                        </thead>
                                        <tbody class="item-append-area">
                                        @foreach($row->accountingDetails as  $exp)
                                            <tr>

                                                <td>{{$exp->expenseItem->name ?? ''}}</td>
                                                <td>{{$exp->item_name}}</td>
                                                <td>{{$exp->quantity}}</td>
                                                <td>{{$exp->price}}</td>
                                                <td>{{ number_format($exp->price * $exp->quantity,4, '.', '')}}</td>

                                            </tr>
                                        @endforeach
                                        <tr>

                                        </tr>

                                        <tr style=" border: 2px dashed #3c8dbc;">
                                            <td colspan="4">Net</td>
                                            <td colspan="2" class="total">{{$row->amount}}</td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            @endif
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
@push('style')
    <link rel="stylesheet" type="text/css"
          href="{{asset('assets/admin/plugins/blueimp/css/blueimp-gallery.min.css')}}"/>


@endpush
@push('script')

    <script src="{{asset('assets/admin/plugins/blueimp/js/jquery.blueimp-gallery.min.js')}}"></script>

@endpush
