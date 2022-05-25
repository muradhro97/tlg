@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.contracts'),'url'=>'contract'])
@stop
@section('content')
    <!-- FILE: app/views/start.blade.php -->
    <div class="ibox-content m-b-sm border-bottom float-e-margins">

        <div class="row">

            @include('partials.validation-errors')
            <div class="pull-right">
                <a class="btn btn-outline btn-primary" target="_blank" href="{{url('admin/contract-print/'.$row->id)}}"><i class="fa fa-print"></i>  {{trans('main.print')}}
                </a>




            </div>
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
                                    <dt>{{trans('main.organization')}}:</dt>
                                    <dd> {{$row->organization->name ?? ''}}      </dd>
                                    <dt>{{trans('main.start_date')}}:</dt>
                                    <dd> {{$row->start_date}}      </dd>
                                    <dt>{{trans('main.no')}}:</dt>
                                    <dd> {{$row->no}}      </dd>
                                    <dt>{{trans('main.type')}}:</dt>
                                    <dd> {{$row->type}}      </dd>
                                    <dt>{{trans('main.price')}}:</dt>
                                    <dd> {{$row->price}}      </dd>
                                    <dt>{{trans('main.city')}}:</dt>
                                    <dd> {{$row->city->name}}      </dd>

                                </dl>
                            </div>
                            <div class="col-lg-7" id="cluster_info">
                                <dl class="dl-horizontal">

                                    <dt>{{trans('main.type')}}:</dt>
                                    <dd> {{$row->contractType->name ?? '...'}}      </dd>
                                    <dt>{{trans('main.project')}}:</dt>
                                    <dd> {{$row->project->name ?? ''}}</dd>
                                    <dt>{{trans('main.finish_date')}}:</dt>
                                    <dd> {{$row->finish_date}}</dd>
                                    <dt>{{trans('main.date')}}:</dt>
                                    <dd> {{$row->date}}</dd>
                                    <dt>{{trans('main.status')}}:</dt>
                                    <dd> {{$row->status}}      </dd>
                                    <dt>{{trans('main.duration')}}:</dt>
                                    <dd> {{$row->duration}}      </dd>
                                    <dt>{{trans('main.details')}}:</dt>
                                    <dd> {{$row->details}}      </dd>


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
                                    <th>{{trans('main.total')}}</th>


                                    </thead>
                                    <tbody class="">
                                    @foreach($row->items as  $inv)
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
                                        <td colspan="2" class="total">{{$row->total}}</td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="m-b-md">
                                    {{--<a href="{{url('admin/employee/'.$row->id.'/edit')}}"--}}
                                    {{--class="btn btn-outline btn-primary  pull-right">{{trans('main.edit')}}</a>--}}
                                    <h2>{{trans('main.documents')}}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @foreach($row->files as $file)
                                <h4>{!! Html::link(route('contract_download',$file->file), $file->file) !!}</h4>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


@stop
