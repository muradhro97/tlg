@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.worker_salaries'),'url'=>'worker-salary'])
@stop
@section('content')
    @inject('safe','App\Safe')


    <?php

    $safes = $safe->oldest()->pluck('name', 'id')->toArray();




    $mangerStatusOptions = [
        'waiting' => 'waiting',
        'accept' => 'accept',
        'decline' => 'decline',
    ];
    $paymentStatusOptions = [
        'waiting' => 'waiting',
        'confirmed' => 'confirmed',
        'cancel' => 'cancel',
    ];

    ?>
    <div class="ibox ibox-primary">
        <div class="ibox-title">
            <h5>{{trans('main.search') }}</h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
                <a class="close-link">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content m-b-sm border-bottom">

            {!! Form::open([
                  'method' => 'GET'
              ]) !!}
            <div class="row">


                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="safe_id">{{trans('main.safe')}}</label>
                        {{Form::select('safe_id', $safes, request()->safe_id, [
                            "class" => "form-control select2 " ,
                            "id" => "safe_id",
                            "placeholder" => trans('main.safe')
                        ])}}
                        {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="manager_status">{{trans('main.manager_status')}}</label>
                        {{Form::select('manager_status', $mangerStatusOptions, request()->manager_status, [
                            "class" => "form-control select2 " ,
                            "id" => "manager_status",
                            "placeholder" => trans('main.manager_status')
                        ])}}
                        {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="payment_status">{{trans('main.payment_status')}}</label>
                        {{Form::select('payment_status', $paymentStatusOptions, request()->payment_status, [
                            "class" => "form-control select2 " ,
                            "id" => "payment_status",
                            "placeholder" => trans('main.payment_status')
                        ])}}
                        {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="payment_status">{{trans('main.amount')}}</label>
                        <input type="text" id="amount" name="mount" value="" placeholder="{{trans('main.amount')}}" class="form-control">
                    </div>
                </div>
                <div class="col-sm-4 text-center">
                    <div class="col-sm-12">
                        <div class="col-sm-6">
                            <label class="control-label" for="from">{{trans('main.from')}}</label>
                            <div class="input-group clockpicker" data-autoclose="true">
                                <input type="text" name="from" class="form-control"
                                       placeholder="{{trans('main.from')}}" value="{{old('from')}}">
                                <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="control-label" for="to">{{trans('main.to')}}</label>
                            <div class="input-group clockpicker" data-autoclose="true">
                                <input type="text" name="to" class="form-control"
                                       placeholder="{{trans('main.to')}}" value="{{old('to')}}">
                                <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-sm-2 ">
                    <div class="form-group">
                        <label for="">&nbsp;</label>
                        <button type="submit"
                                class="btn btn-flat  btn-primary btn-md">{{trans('main.search') }}</button>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <div class="ibox ibox-primary">
        <div class="ibox-title">
            <h5>{{trans('main.worker_salaries') }}</h5>
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
            @can('addWorkerSalary')
                <div class="">
                    <a href="{{url('admin/worker-salary/create')}}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> {{trans('main.new') }}
                    </a>
                </div>
            @endcan
            <div class="clearfix"></div>
            <br>


            @if($rows->count()>0)
                <a href="{{route('worker_salaries.export')}}" class="btn btn-primary">
                    <i class="fa fa-file-excel-o"></i>
                    {{trans('main.excel')}}
                </a>
                <div class="table-responsive">
                    <table class="data-table table table-bordered print_table">
                        <thead>
                        <th>#</th>
                        {{--                        <th>{{trans('main.transaction_no') }}</th>--}}
                        <th>{{trans('main.amount') }}</th>
                        {{--                        <th>{{trans('main.custody_transaction_no') }}</th>--}}
                        <th>{{trans('main.from') }}</th>
                        <th>{{trans('main.to') }}</th>
                        <th>{{trans('main.manager_status') }}</th>
                        <th>{{trans('main.payment_status') }}</th>
                        <th>{{trans('main.safe') }}</th>

                        @can('detailsWorkerSalary')
                            <th>{{trans('main.options') }}</th>
                        @endcan
                        {{--<th class="text-center">{{trans('main.edit') }}</th>--}}
                        {{--<th class="text-center">{{trans('main.delete') }}</th>--}}
                        </thead>
                        <tbody>
                        @php $count = 1; @endphp
                        @foreach($rows as $row)
                            <?php
                            $iteration = $loop->iteration + (($rows->currentPage() - 1) * $rows->perPage())
                            ?>
                            <tr>
                                <td>{{$iteration}}</td>
                                {{--                                <td>{{$row->id}}</td>--}}
                                <td>{{number_format($row->amount,2)}}</td>
                                {{--                                <td>{{$row->safe_transaction_id ?? ''}}</td>--}}
                                <td>{{$row->start}}</td>
                                <td>{{$row->end}}</td>
                                <td>{{$row->manager_status}}</td>
                                <td>{{$row->payment_status}}</td>
                                <td>{{$row->safe->name ?? ''}}</td>

                                @can('detailsWorkerSalary')
                                    <td>

                                        <a style="margin: 2px;" type="button"
                                           href="{{url('admin/worker-salary/'.$row->id)}}"
                                           class="btn btn-sm btn-primary"><i
                                                    class="fa fa-eye"></i></a>
                                    </td>
                                @endcan

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
                    {!! $rows->appends(request()->except('page'))->links() !!}
                </div>
            @else
                <h2 class="text-center">{{trans('main.no_records') }}</h2>
            @endif
            <div class="clearfix"></div>
        </div>
    </div>

    @push('script')

        <script>
            $(document).ready(function () {
                $('.print_table').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'print',
                            className: 'btn btn-primary  hide-for-mobile',
                            {{--text: "<i class=fa fa-print'></i>  {{trans('main.print')}}",--}}
                            text:      '<i class="fa fa-print"></i> {{trans("main.print")}}',
                            autoPrint: true,
                            title: "",
                            init: function(api, node, config) {
                                $(node).removeClass('dt-button')
                            },
                            exportOptions: {
                                columns: [ 0, 1 ,2,3,4,5,6,7]
                            }
                        }
                    ],
                    "paging": false,
                    "ordering": false,
                    "searching": false,
                    "info": false
                });
            });

        </script>
    @endpush
@stop
