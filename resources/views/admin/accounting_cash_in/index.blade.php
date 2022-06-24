@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.accounting_cash_in'),'url'=>'accounting-cash-in'])
@stop
@section('content')
@inject('organization','App\Organization')
@inject('project','App\Project')
@inject('contract','App\Contract')

@inject('safe','App\Safe')





<?php

$safes = $safe->oldest()->pluck('name', 'id')->toArray();


$contracts = $contract->latest()->pluck('no', 'id')->toArray();
$organizations = $organization->latest()->pluck('name', 'id')->toArray();


$projects = $project->latest()->whereIn('id', auth()->user()->projects->pluck('id')->toArray())->pluck('name', 'id')->toArray();

$mangerStatusOptions=[
    'waiting'=>'waiting',
    'accept'=>'accept',
    'decline'=>'decline',
];
$paymentStatusOptions=[
    'waiting'=>'waiting',
    'confirmed'=>'confirmed',
    'cancel'=>'cancel',
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
                        <label class="control-label" for="project_id">{{trans('main.project')}}</label>
                        {{Form::select('project_id', $projects,  request()->project_id, [
                            "class" => "form-control select2 " ,
                            "id" => "project_id",
                            "placeholder" => trans('main.project')
                        ])}}
                        {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="organization_id">{{trans('main.organization')}}</label>
                        {{Form::select('organization_id', $organizations, request()->organization_id, [
                            "class" => "form-control select2 " ,
                            "id" => "organization_id",
                            "placeholder" => trans('main.organization')
                        ])}}
                        {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="contract_id">{{trans('main.contract')}}</label>
                        {{Form::select('contract_id', $contracts,  request()->contract_id, [
                            "class" => "form-control select2 " ,
                            "id" => "contract_id",
                            "placeholder" => trans('main.contract')
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
            <h5>{{trans('main.accounting_cash_in') }}</h5>
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

            @can('addAccountingCashIn')
                <div class="">
                    <a href="{{url('admin/accounting-cash-in/create')}}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> {{trans('main.new') }}
                    </a>
                </div>
            @endcan
            <div class="clearfix"></div>
            <br>


            @if($rows->count()>0)
                <div class="table-responsive">
                    <table class="data-table table table-bordered print_table">
                        <thead>
                        <th>#</th>
                        <th>{{trans('main.id') }}</th>
                        <th>{{trans('main.type') }}</th>
                        <th>{{trans('main.date') }}</th>
                        <th>{{trans('main.amount') }}</th>
                        {{--                        <th>{{trans('main.custody_transaction_no') }}</th>--}}
                        <th>{{trans('main.project') }}</th>
                        <th>{{trans('main.transaction_cheque_no') }}</th>
                        <th>{{trans('main.organization') }}</th>
                        <th>{{trans('main.contract') }}</th>
                        <th>{{trans('main.safe') }}</th>
                        <th>{{trans('main.submitted_by') }}</th>
                        {{--<th>{{trans('main.safe_balance') }}</th>--}}
                        {{--<th>{{trans('main.safe_new_balance') }}</th>--}}
                        <th>{{trans('main.manager_status') }}</th>
                        <th>{{trans('main.payment_status') }}</th>
                        @can('detailsAccountingCashIn')
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
                                <td>{{$row->id}}</td>
                                <td>{{$row->type}}</td>
                                <td>{{$row->date}}</td>
                                <td>{{$row->amount}}</td>
                                {{--                                <td>{{$row->safe_transaction_id ?? ''}}</td>--}}
                                <td>{{$row->project->name ?? ''}}</td>
                                <td>{{$row->transaction_cheque_no}}</td>
                                <td>{{$row->organization->name ?? ''}}</td>
                                <td>{{$row->contract->no ?? ''}}</td>
                                <td>{{$row->safe->name ?? ''}}</td>
                                <td>{{$row->employee->name ?? ''}}</td>
                                {{--<td>{{$row->balance}}</td>--}}
                                {{--<td>{{$row->new_balance}}</td>--}}
                                <td>{{$row->manager_status}}</td>
                                <td>{{$row->payment_status}}</td>
                                @can('detailsAccountingCashIn')
                                    <td>

                                        <a style="margin: 2px;" type="button"
                                           href="{{url('admin/accounting-cash-in/'.$row->id)}}"
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
                            columns: [ 0, 1 ,2,3,4,5,6,7,8,9,10,11]
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
