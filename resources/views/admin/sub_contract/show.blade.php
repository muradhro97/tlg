@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.sub_contracts'),'url'=>'sub-contract'])
@stop
@section('content')
    <!-- FILE: app/views/start.blade.php -->
    <div class="ibox-content m-b-sm border-bottom float-e-margins">

        <div class="row">

            @include('partials.validation-errors')
            <div class="pull-right">
                <a class="btn btn-outline btn-primary" target="_blank" href="{{url('admin/sub-contract-print/'.$row->id)}}"><i class="fa fa-print"></i>  {{trans('main.print')}}
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
                {{--<a class="btn btn-outline btn-warning" target="_blank" href="{{url('admin/contract/'.$row->id)}}"><i--}}
                {{--class="fa fa-print"></i> {{trans('main.print')}}--}}
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

    <div class="ibox ibox-primary">
        <div class="ibox-title">
            <h5>{{trans('main.extracts') }}</h5>
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
            <div class="">

                <a href="{{url('admin/contract/'.$row->id.'/extract/create')}}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> {{trans('main.new') }}
                </a>
            </div>
            <div class="clearfix"></div>
            <br>


            @if($row->extracts->count()>0)
                <div class="table-responsive">
                    <table class="data-table table table-bordered">
                        <thead>

                        <th>#</th>

                        <th>{{trans('main.date') }}</th>
                        <th>{{trans('main.sub_contract') }}</th>
                        <th>{{trans('main.total') }}</th>
                        <th>{{trans('main.contract_type') }}</th>

                        <th>{{trans('main.organization') }}</th>
                        <th>{{trans('main.project') }}</th>
                        <th>{{trans('main.period_from') }}</th>
                        <th>{{trans('main.period_to') }}</th>


                        <th>{{trans('main.options') }}</th>

                        {{--<th class="text-center">{{trans('main.edit') }}</th>--}}
                        {{--<th class="text-center">{{trans('main.delete') }}</th>--}}
                        </thead>
                        <tbody>
                        @php $count = 1; @endphp
                        @foreach($row->extracts as $ex)

                            <tr>
                                <td>{{$loop->iteration}}</td>
                                {{--                                <td>{{$row->id}}</td>--}}
{{--                                <td>{{$ex->id}}</td>--}}
                                <td>{{$ex->date}}</td>
                                <td>{{$ex->subContract->no ?? ''}}</td>
                                <td>{{$ex->total}}</td>

                                {{--                                <td>{{$ex->safe_transaction_id ?? ''}}</td>--}}
                                <td>{{$ex->subContract->contractType->name ?? ''}}</td>
                                <td>{{$ex->organization->name ?? ''}}</td>
                                <td>{{$ex->project->name ?? ''}}</td>

                                {{--<td>{{$ex->balance}}</td>--}}
                                {{--<td>{{$ex->new_balance}}</td>--}}
                                <td>{{$ex->period_from}}</td>
                                <td>{{$ex->period_to}}</td>

                                <td>

                                    <a  style="margin: 2px;" type="button" href="{{url('admin/extract/'.$ex->id)}}"
                                        class="btn btn-sm btn-primary"><i
                                                class="fa fa-eye"></i></a>
                                </td>

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
                            @php $count ++; @endphp
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-center">
                    {{--{!! $rows->appends(request()->except('page'))->links() !!}--}}
                </div>
            @else
                <h2 class="text-center">{{trans('main.no_records') }}</h2>
            @endif
            <div class="clearfix"></div>
        </div>
    </div>
@stop
