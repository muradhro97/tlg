@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.safe_transactions'),'url'=>'safe-transaction'])
@stop
@section('content')





    <?php


    $typeOptions = [
        'cashin' => 'cashin',
        'cashout' => 'cashout',
        'custody' => 'custody',
        'custodyRest' => 'custodyRest',
        'invoice' => 'invoice',
        'expense' => 'expense',
        'workerLoan' => 'workerLoan',
        'employeeLoan' => 'employeeLoan',
        'workerSalary' => 'workerSalary',
        'employeeSalary' => 'employeeSalary',

    ];

    $routeOptions = [
        'cashin' => 'accounting-cash-in',
        'invoice' => 'invoice',
        'expense' => 'invoice',
        'workerLoan' => 'worker-loan',
        'employeeLoan' => 'employee-loan',
        'workerSalary' => 'worker-salary',
        'employeeSalary' => 'employee-salary',

    ];
    $moduleOptions = [
        'treasury' => 'treasury',
        'accounting' => 'accounting',


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
                {{--                <div class="col-sm-3">--}}
                {{--                    <div class="form-group">--}}
                {{--                        <label class="control-label" for="type">{{trans('main.type')}}</label>--}}
                {{--                        {{Form::select('type', $typeOptions, request()->type, [--}}
                {{--                            "class" => "form-control select2 " ,--}}
                {{--                            "id" => "type",--}}
                {{--                            "placeholder" => trans('main.type')--}}
                {{--                        ])}}--}}
                {{--                        --}}{{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                {{--                <div class="col-sm-3">--}}
                {{--                    <div class="form-group">--}}
                {{--                        <label class="control-label" for="module">{{trans('main.module')}}</label>--}}
                {{--                        {{Form::select('module', $moduleOptions, request()->module, [--}}
                {{--                            "class" => "form-control select2 " ,--}}
                {{--                            "id" => "module",--}}
                {{--                            "placeholder" => trans('main.module')--}}
                {{--                        ])}}--}}
                {{--                        --}}{{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
                {{--                    </div>--}}
                {{--                </div>--}}

                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="date">{{trans('main.from')}}</label>
                        <div class="input-group date">

                            {!! Form::text('from',request()->from,[
                                'class' => 'form-control ',
                                'placeholder' => trans('main.from'),
                                 "id" => 'filter-from'
                            ]) !!}
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="to">{{trans('main.to')}}</label>
                        <div class="input-group date">

                            {!! Form::text('to',request()->to,[
                                'class' => 'form-control ',
                                'placeholder' => trans('main.to'),
                                 "id" => 'filter-to'
                            ]) !!}
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
                {{--<div class="col-sm-3">--}}
                {{--<div class="form-group">--}}
                {{--<label class="control-label" for="safe_id">{{trans('main.safe')}}</label>--}}
                {{--{{Form::select('safe_id', $safes, request()->safe_id, [--}}
                {{--"class" => "form-control select2 " ,--}}
                {{--"id" => "safe_id",--}}
                {{--"placeholder" => trans('main.safe')--}}
                {{--])}}--}}
                {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
                {{--</div>--}}
                {{--</div>--}}

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
            <h5>{{trans('main.safe_transactions') }}</h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
                <a class="close-link">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
        <div id="tablePrint" class="ibox-content x_content">
            {{--<div class="">--}}
            {{--<a href="{{url('admin/cash-in')}}" class="btn btn-primary">--}}
            {{--<i class="fa fa-plus"></i> {{trans('main.cash_in') }}--}}
            {{--</a>--}}
            {{--<a href="{{url('admin/cash-out')}}" class="btn btn-primary">--}}
            {{--<i class="fa fa-plus"></i> {{trans('main.cash_out') }}--}}
            {{--</a>--}}

            {{--<a href="{{url('admin/custody')}}" class="btn btn-primary">--}}
            {{--<i class="fa fa-plus"></i> {{trans('main.custody') }}--}}
            {{--</a>--}}
            {{--</div>--}}

            <div class="clearfix"></div>
            <br>

            <div class="row ">
                <button id="prinbtThis" class="noPrint btn btn-success x_content">
                    <i class="fa fa-print"></i>
                    إطبع
                </button>
                <div class="col-md-6 x_content">
                    <h4>{{trans('main.cash_out') }}</h4>
                    @if($safe_transactions->count()>0)
                        <div class="table-responsive">
                            <table class=" table table-bordered myTable ">
                                <thead>
                                <th>#</th>
                                <th>{{trans('main.transaction_no') }}</th>
                                <th>{{trans('main.transaction_date') }}</th>
                                <th>{{trans('main.date') }}</th>
                                <th>{{trans('main.type') }}</th>
                                <th>{{trans('main.amount') }}</th>
                                {{--                        <th>{{trans('main.custody_transaction_no') }}</th>--}}
                                {{--<th data-hide="all" >{{trans('main.organization') }}</th>--}}
                                {{--<th data-hide="all" >{{trans('main.project') }}</th>--}}
                                {{--<th data-hide="all" >{{trans('main.employee') }}</th>--}}
                                <th>{{trans('main.safe_balance') }}</th>
                                <th>{{trans('main.safe_new_balance') }}</th>
                                {{--                        <th>{{trans('main.status') }}</th>--}}

                                <th>{{trans('main.options') }}</th>

                                {{--<th class="text-center">{{trans('main.edit') }}</th>--}}
                                {{--<th class="text-center">{{trans('main.delete') }}</th>--}}
                                </thead>
                                <tbody>
                                @php $count = 1; @endphp
                                @foreach($safe_transactions as $row)
                                    <?php
                                    $iteration = $loop->iteration
                                    ?>
                                    <tr>
                                        <td>{{$iteration}}</td>
                                        <td>{{$row->id}}</td>
                                        <td>{{$row->created_at->toDayDateTimeString() }}</td>
                                        <td>{{ $row->parent->date ?? ''}}</td>
                                        <td>{{ $row->parent->type ?? ''}}</td>
                                        <td>{{$row->amount}}</td>
                                        {{--                                <td>{{$row->safe_transaction_id ?? ''}}</td>--}}
                                        {{--<td>{{$row->parent->organization->name ?? ''}}</td>--}}
                                        {{--<td>{{$row->parent->project->name ?? ''}}</td>--}}
                                        {{--<td>{{$row->parent->employee->name ?? ''}}</td>--}}
                                        <td>{{$row->balance}}</td>
                                        <td>{{$row->new_balance}}</td>
                                        {{--                                <td>{{$row->status}}</td>--}}

                                        {{--<td>@if($row->type=="custody" and $row->status== "open")--}}

                                        {{--<a  type="button" href="{{url('admin/custody-rest/'.$row->id)}}"--}}
                                        {{--class="btn btn-sm btn-primary"><i--}}
                                        {{--class="fa fa-retweet"></i> {{trans('main.rest')}}</a>--}}




                                        {{--@endif--}}


                                        <td>
                                            <a style="margin: 2px;" type="button"
                                               href="
                                               @if($row->module =="treasury")
                                               {{url('admin/payment/'.$row->payment_id)}}
                                               @elseif($row->module =="accounting" and   $row->parent)
                                               {{url('admin/'.$routeOptions[$row->parent->type].'/'.$row->accounting_id)}}
                                               @endif"
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
                                <tfoot>
                                <tr>
                                    <td colspan=2">TOTAL</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>{{number_format($safe_transactions->sum('amount'),2)}}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>

                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    @else
                        <h2 class="text-center">{{trans('main.no_records') }}</h2>
                    @endif
                </div>
                <div class="col-md-6">
                    <h4>{{trans('main.cash_in') }}</h4>
                    @if($safe_transactions_cash_in->count()>0)
                        <div class="table-responsive">
                            <table class=" table table-bordered myTable ">
                                <thead>
                                <th>#</th>
                                <th>{{trans('main.transaction_no') }}</th>
                                <th>{{trans('main.transaction_date') }}</th>
                                <th>{{trans('main.date') }}</th>
                                <th>{{trans('main.type') }}</th>
                                <th>{{trans('main.amount') }}</th>
                                {{--                        <th>{{trans('main.custody_transaction_no') }}</th>--}}
                                {{--<th data-hide="all" >{{trans('main.organization') }}</th>--}}
                                {{--<th data-hide="all" >{{trans('main.project') }}</th>--}}
                                {{--<th data-hide="all" >{{trans('main.employee') }}</th>--}}
                                <th>{{trans('main.safe_balance') }}</th>
                                <th>{{trans('main.safe_new_balance') }}</th>
                                {{--                        <th>{{trans('main.status') }}</th>--}}

                                <th>{{trans('main.options') }}</th>

                                {{--<th class="text-center">{{trans('main.edit') }}</th>--}}
                                {{--<th class="text-center">{{trans('main.delete') }}</th>--}}
                                </thead>
                                <tbody>
                                @php $count = 1; @endphp
                                @foreach($safe_transactions_cash_in as $row)
                                    <?php
                                    $iteration = $loop->iteration
                                    ?>
                                    <tr>
                                        <td>{{$iteration}}</td>
                                        <td>{{$row->id}}</td>
                                        <td>{{$row->created_at->toDayDateTimeString() }}</td>
                                        <td>{{ $row->parent->date ?? ''}}</td>
                                        <td>{{ $row->parent->type ?? ''}}</td>
                                        <td>{{$row->amount}}</td>
                                        {{--                                <td>{{$row->safe_transaction_id ?? ''}}</td>--}}
                                        {{--<td>{{$row->parent->organization->name ?? ''}}</td>--}}
                                        {{--<td>{{$row->parent->project->name ?? ''}}</td>--}}
                                        {{--<td>{{$row->parent->employee->name ?? ''}}</td>--}}
                                        <td>{{$row->balance}}</td>
                                        <td>{{$row->new_balance}}</td>
                                        {{--                                <td>{{$row->status}}</td>--}}

                                        {{--<td>@if($row->type=="custody" and $row->status== "open")--}}

                                        {{--<a  type="button" href="{{url('admin/custody-rest/'.$row->id)}}"--}}
                                        {{--class="btn btn-sm btn-primary"><i--}}
                                        {{--class="fa fa-retweet"></i> {{trans('main.rest')}}</a>--}}




                                        {{--@endif--}}


                                        <td>
                                            <a style="margin: 2px;" type="button"
                                               href="
                                               @if($row->module =="treasury")
                                                    {{url('admin/payment/'.$row->payment_id)}}
                                               @elseif($row->module =="accounting" and   $row->parent)
                                                    {{url('admin/'.$routeOptions[$row->parent->type].'/'.$row->accounting_id)}}
                                               @endif"
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
                                <tfoot>
                                <tr>
                                    <td colspan=2">TOTAL</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>{{number_format($safe_transactions_cash_in->sum('amount'),2)}}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>

                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    @else
                        <h2 class="text-center">{{trans('main.no_records') }}</h2>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-6 col-lg-offset-3">
                    <div class="col-md-6">
                        <h4>{{trans('main.safe') }}</h4>
                        <div class="table-responsive">
                            <table class=" table table-bordered">
                                <tbody>
                                <tr>
                                    <td>{{trans('main.safe_balance') }}</td>
                                    <td>{{$old_transaction->balance}}</td>
                                </tr>
                                <tr>
                                    <td>{{trans('main.cash_in') }}</td>
                                    <td>{{number_format($safe_transactions_cash_in->sum('amount'),2)}}</td>
                                </tr>
                                <tr>
                                    <td>{{trans('main.cash_out') }}</td>
                                    <td>{{number_format($safe_transactions->sum('amount'),2)}}</td>
                                </tr>
                                <tr>
                                    <td>{{trans('main.safe_new_balance') }}</td>
                                    <td>{{$new_transaction->new_balance}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
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
                            text: '<i class="fa fa-print"></i> {{trans("main.print")}}',
                            autoPrint: true,
                            title: "",
                            init: function (api, node, config) {
                                $(node).removeClass('dt-button')
                            },
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
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
