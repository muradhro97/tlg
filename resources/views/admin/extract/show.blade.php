@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.extracts'),'url'=>'extract'])
@stop
@section('content')
    <!-- FILE: app/views/start.blade.php -->
    <div class="ibox-content m-b-sm border-bottom float-e-margins">

        <div class="row">

            @include('partials.validation-errors')
            <div class="pull-right">
                <a class="btn btn-outline btn-primary" target="_blank" href="{{url('admin/extract-print/'.$row->id)}}"><i class="fa fa-print"></i>  {{trans('main.print')}}
                </a>




            </div>
            @if($row->type=="cashin" and $row->payment_status=="waiting" )


                <form method="post" action="{{route('accounting-change-status')}}" style="display: inline;">
                    {{csrf_field()}}

                    <input type="hidden" name="id" value="{{$row->id}}">
                    <button class="btn btn-primary btn-outline " type="submit" name="payment_status" value="confirmed"><i
                            class="fa fa-check"></i> {{trans('main.confirm')}}
                    </button>

                    <button class="btn btn-danger btn-outline " type="submit" name="payment_status" value="cancel"><i
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
                                    <dt>{{trans('main.payment_status')}}:</dt>
                                    <dd><span class="label label-primary">{{$row->payment_status}}</span></dd>
                                </dl>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5">
                                <dl class="dl-horizontal">


                                    <dt>{{trans('main.id')}}:</dt>
                                    <dd> {{$row->id}}      </dd>
                                    <dt>{{trans('main.number')}}:</dt>
                                    <dd> {{$row->number}}      </dd>
                                    <dt>{{trans('main.sub_contract')}}:</dt>
                                    <dd> {{$row->subContract->no ?? ''}}      </dd>
                                    <dt>{{trans('main.organization')}}:</dt>
                                    <dd> {{$row->organization->name ?? ''}}      </dd>
                                    <dt>{{trans('main.period_from')}}:</dt>
                                    <dd> {{$row->period_from}}      </dd>
                                    <dt>{{trans('main.net')}}:</dt>
                                    <dd> {{$row->total}}      </dd>
                                    <dt>{{trans('main.details')}}:</dt>
                                    <dd> {{$row->details}}      </dd>

                                </dl>
                            </div>
                            <div class="col-lg-7" id="cluster_info">
                                <dl class="dl-horizontal">
                                    <dt>{{trans('main.date')}}:</dt>
                                    <dd> {{$row->date}}      </dd>
                                    <dt>{{trans('main.contract_type')}}:</dt>
                                    <dd> {{$row->subContract->contractType->name ?? ''}}     </dd>
                                    <dt>{{trans('main.project')}}:</dt>
                                    <dd> {{$row->project->name ?? ''}}</dd>
                                    <dt>{{trans('main.period_to')}}:</dt>
                                    <dd> {{$row->period_to}}      </dd>


                                </dl>
                            </div>
                        </div>
                        <div class="row">
                            <div class="table-responsive">
                                <table class="data-table table table-bordered">
                                    <thead>
                                    {{--<th>#</th>--}}
                                    <th>{{trans('main.item_name')}}</th>
                                    <th>{{trans('main.quantity')}}</th>
                                    <th>{{trans('main.price')}}</th>
                                    <th>{{trans('main.exchange_ratio')}}</th>
                                    <th>{{trans('main.total')}}</th>


                                    </thead>
                                    <tbody class="">
                                    <?php
                                    $total_plus = 0;
                                    $total_minus = 0;
                                    ?>
                                    @foreach($row->plus_items as  $inv)
                                        <?php
                                        $total_plus += $inv->price * $inv->quantity * $inv->exchange_ratio/100;
                                        ?>
                                        <tr style="{{$inv->item->is_minus? 'border: 2px dashed #d72323' : ''}}">

                                            <td>{{$inv->item->name ?? ''}}</td>
                                            <td>{{$inv->quantity?? '---'}}</td>
                                            <td>{{number_format($inv->price,2)}}</td>
                                            <td>{{$inv->exchange_ratio?? '---'}}</td>
                                            @if(!$inv->item->is_minus)
                                                <td>{{ number_format($inv->price * $inv->quantity * $inv->exchange_ratio/100,4, '.', '')}}</td>
                                            @else
                                                <td>{{number_format($inv->price,2)}}</td>
                                            @endif

                                        </tr>
                                    @endforeach
                                    <tr>

                                    </tr>

                                    <tr style=" border: 2px dashed #3c8dbc;">
                                        <td colspan="4">{{trans('main.total')}}</td>
                                        <td colspan="2" class="total">{{number_format($total_plus,2)}}</td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="table-responsive">
                                <table class="data-table table table-bordered">
                                    <thead>
                                    {{--<th>#</th>--}}
                                    <th>{{trans('main.item_name')}}</th>
                                    <th>{{trans('main.quantity')}}</th>
                                    <th>{{trans('main.price')}}</th>
                                    <th>{{trans('main.exchange_ratio')}}</th>
                                    <th>{{trans('main.total')}}</th>
                                    </thead>
                                    <tbody class="">
                                    @foreach($row->minus_items as  $inv)
                                        <?php
                                        $total_minus += $inv->price;
                                        ?>
                                        <tr style="{{$inv->item->is_minus? 'border: 2px dashed #d72323' : ''}}">

                                            <td>{{$inv->item->name ?? ''}}</td>
                                            <td>{{$inv->quantity?? '---'}}</td>
                                            <td>{{number_format($inv->price,2)}}</td>
                                            <td>{{$inv->exchange_ratio?? '---'}}</td>
                                            @if(!$inv->item->is_minus)
                                                <td>{{ number_format($inv->price * $inv->quantity * $inv->exchange_ratio/100,4, '.', '')}}</td>
                                            @else
                                                <td>{{number_format($inv->price,2)}}</td>
                                            @endif

                                        </tr>
                                    @endforeach
                                    <tr>

                                    </tr>

                                    <tr style=" border: 2px dashed #3c8dbc;">
                                        <td colspan="4">{{trans('main.total')}}</td>
                                        <td colspan="2" class="total">{{number_format($total_minus,2)}}</td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                            <hr>
                            <h2 class="text-center">
                                {{trans('main.net')}}:
                                {{number_format($total_plus+$total_minus,2)}}
                            </h2>
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
