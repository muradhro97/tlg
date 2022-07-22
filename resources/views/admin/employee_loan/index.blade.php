@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.employee_loans'),'url'=>'employee-loan'])
@stop
@section('content')
    @inject('safe','App\Safe')
    @inject('employee','App\Employee')





    <?php

    $safes = $safe->oldest()->pluck('name', 'id')->toArray();
    $employees = $employee->oldest()->pluck('name', 'id')->toArray();



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
                        <label class="control-label" for="employee_id">{{trans('main.employee')}}</label>
                        {{Form::select('employee_id', $employees, request()->employee_id, [
                            "class" => "form-control select2 " ,
                            "id" => "employee_id",
                            "placeholder" => trans('main.employee')
                        ])}}
                        {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
                    </div>
                </div>
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
                        <label class="control-label" for="date">{{trans('main.date')}}</label>
                        <div class="input-group date">

                            {!! Form::text('date',request()->date,[
                                'class' => 'form-control datepicker',
                                'placeholder' => trans('main.date'),

                            ]) !!}
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
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
            <h5>{{trans('main.employee_loans') }}</h5>
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

            @can('addEmployeeLoan')
                <div class="">
                    <a href="{{url('admin/employee-loan/create')}}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> {{trans('main.new') }}
                    </a>
                </div>
            @endcan
            <div class="clearfix"></div>
            <br>


            @if($rows->count()>0)
            <form method="post" action="{{route('worker-loan-manager-change-statuses')}}"
                  style="display: inline;">
                @can('managerAcceptDeclineWorkerLoan')
                    <button class="btn btn-primary btn-outline " type="submit" name="manager_status" value="accept">
                        <i
                            class="fa fa-check"></i> {{trans('main.manager_accept')}}
                    </button>
                    <button class="btn btn-danger btn-outline " type="submit" name="manager_status" value="decline">
                        <i
                            class="fa fa-times"></i> {{trans('main.manager_decline')}}
                    </button>
                @endcan
                {{csrf_field()}}
                <div class="table-responsive">
                    <div class="pull-right">
                        <a class="btn btn-outline btn-primary" target="_blank" href="{{url('admin/employee-loans-print')}}"><i class="fa fa-print"></i>  {{trans('main.print')}}
                        </a>
                    </div>
                    <table class="data-table table table-bordered print_table">
                        <thead>
                        <th>#</th>
                        <th>{{trans('main.id') }}</th>
                        <th>{{trans('main.date') }}</th>
                        <th>{{trans('main.employee') }}</th>
                        <th>{{trans('main.amount') }}</th>
                        {{--                        <th>{{trans('main.custody_transaction_no') }}</th>--}}

                        <th>{{trans('main.safe') }}</th>
                        {{--<th>{{trans('main.safe_balance') }}</th>--}}
                        {{--<th>{{trans('main.safe_new_balance') }}</th>--}}
                        <th>{{trans('main.manager_status') }}</th>
                        <th>{{trans('main.payment_status') }}</th>
                        <th>{{trans('main.Was Custody') }}</th>
                        <th>{{trans('main.status') }}</th>
                        @can('detailsEmployeeLoan')
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
                                <td>
                                    @if($row->type=="employeeLoan" and $row->manager_status=="waiting"  )
                                        <input type="checkbox" value="{{$row->id}}" name="ids[]">
                                    @endif
                                </td>
                                <td>{{$row->id}}</td>
                                <td>{{$row->date}}</td>
                                <td>{{$row->employee->name ?? ''}}</td>
                                <td>{{number_format($row->amount,2)}}</td>
                                {{--                                <td>{{$row->safe_transaction_id ?? ''}}</td>--}}

                                <td>{{$row->safe->name ?? ''}}</td>
                                {{--<td>{{$row->balance}}</td>--}}
                                {{--<td>{{$row->new_balance}}</td>--}}
                                <td>{{$row->manager_status}}</td>
                                <td>{{$row->payment_status}}</td>
                                <td>{{$row->is_was_custody? 'yes':'---'}}</td>
                                <td>{{is_null($row->accounting_id) ? '---' : 'deducted'}}</td>
                                @can('detailsEmployeeLoan')
                                    <td>

                                        <a style="margin: 2px;" type="button"
                                           href="{{url('admin/employee-loan/'.$row->id)}}"
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
                        <tfoot>
                        <tr>
                            <td colspan="4"></td>
                            <td>{{$total}}</td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </form>
                <div class="text-center">
                    {!! $rows->appends(request()->except('page'))->links() !!}
                </div>
            @else
                <h2 class="text-center">{{trans('main.no_records') }}</h2>
            @endif
            <div class="clearfix"></div>
        </div>
    </div>
    @push('script1')

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
                                columns: [ 0, 1 ,2,3,4]
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
