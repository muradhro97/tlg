@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.stock_orders'),'url'=>'stock-order'])
@stop
@section('content')
    @inject('organization','App\Organization')
    @inject('project','App\Project')
    @inject('employee','App\Employee')
    @inject('worker','App\Worker')

    @inject('stockType','App\StockType')






    <?php


    $organizations = $organization->latest()->pluck('name', 'id')->toArray();
    $employees = $employee->latest()->pluck('name', 'id')->toArray();
    $workers = $worker->latest()->pluck('name', 'id')->toArray();

    $stockTypes = $stockType->latest()->pluck('name', 'id')->toArray();
    $projects = $project->latest()->whereIn('id', auth()->user()->projects->pluck('id')->toArray())->pluck('name', 'id')->toArray();

    $custodyTypeOptions = [
        'permanent' => trans('main.permanent'),
        'consumed' => trans('main.consumed'),
        'refundable' => trans('main.refundable'),
    ];
    $typeOptions = [
        'in' => trans('main.in'),
        'out' => trans('main.out'),
    ];
    $statusOptions = [
        'waiting' => trans('main.waiting'),
        'accept' => trans('main.accept'),
        'approve' => trans('main.approve'),
        'cancel' => trans('main.cancel'),
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
                        <label class="control-label" for="worker_id">{{trans('main.worker')}}</label>
                        {{Form::select('worker_id', $workers, request()->worker_id, [
                            "class" => "form-control select2 " ,
                            "id" => "worker_id",
                            "placeholder" => trans('main.worker')
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
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="stock_type">{{trans('main.stock_type')}}</label>
                        {{Form::select('stock_type', $stockTypes, request()->stock_type, [
                            "class" => "form-control select2 " ,
                            "id" => "stock_type",
                            "placeholder" => trans('main.stock_type')
                        ])}}
                        {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="custody_type">{{trans('main.custody_type')}}</label>
                        {{Form::select('custody_type', $custodyTypeOptions, request()->custody_type, [
                            "class" => "form-control select2 " ,
                            "id" => "custody_type",
                            "placeholder" => trans('main.custody_type')
                        ])}}
                        {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="type">{{trans('main.type')}}</label>
                        {{Form::select('type', $typeOptions, request()->type, [
                            "class" => "form-control select2 " ,
                            "id" => "type",
                            "placeholder" => trans('main.type')
                        ])}}
                        {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="status">{{trans('main.status')}}</label>
                        {{Form::select('status', $statusOptions, request()->status, [
                            "class" => "form-control select2 " ,
                            "id" => "status",
                            "placeholder" => trans('main.status')
                        ])}}
                        {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
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
            <h5>{{trans('main.stock_orders') }}</h5>
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
                @can('stockIn')
                    <a href="{{url('admin/stock-in')}}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> {{trans('main.stock_in') }}
                    </a>
                @endcan
                @can('stockOut')
                    <a href="{{url('admin/stock-out')}}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> {{trans('main.stock_out') }}
                    </a>
                @endcan
            </div>

            <div class="clearfix"></div>
            <br>


            @if($rows->count()>0)
                <div class="table-responsive">
                    <table class="data-table table table-bordered  print_table">
                        <thead>
                        <th>#</th>
                        <th>{{trans('main.date') }}</th>
                        <th>{{trans('main.employee') }}</th>
                        <th>{{trans('main.worker') }}</th>
                        <th>{{trans('main.project') }}</th>
                        <th>{{trans('main.custody_type') }}</th>
                        <th>{{trans('main.type') }}</th>
                        <th>{{trans('main.stock_type') }}</th>
                        <th>{{trans('main.status') }}</th>
                        <th>{{trans('main.approved_by') }}</th>
                        <th>{{trans('main.total') }}</th>
                        @can('detailsStockOrder')
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
                                <td>{{$row->date}}</td>
                                <td>{{$row->employee->name ?? '---'}}</td>
                                <td>{{$row->worker->name ?? '---'}}</td>
                                <td>{{$row->project->name ?? ''}}</td>
                                <td>{{$row->custody_type}}</td>
                                <td>{{$row->type}}</td>
                                <td>{{$row->stockType->name ?? ''}}</td>
                                <td>{{$row->status}}</td>
                                <td>{{$row->approvedBy->name ?? ''}}</td>
                                <td>{{$row->total}}</td>
                                <td>
                                @can('detailsStockOrder')
                                    <a style="margin: 2px;" type="button"
                                           href="{{url('admin/stock-order/'.$row->id)}}"
                                           class="btn btn-sm btn-primary"><i
                                                    class="fa fa-eye"></i></a>
                                @endcan
                                @can('stockOutToLoan')
                                    @if($row->type=="out" and $row->status== "approve" and !$row->is_to_loan)
                                            <a type="button" href="{{url('admin/stock_out-to-loan/'.$row->id)}}"
                                               class="btn btn-sm btn-primary"><i
                                                    class="fa fa-retweet"></i> {{trans('main.Convert To Loan')}}</a>
                                    @endif
                                @endcan
                                @if($row->type=="out" and $row->status== "approve" and $row->is_to_loan)
                                    <span class=" btn-sm btn-primary">{{trans('main.Converted To Loan')}}</span>
                                @endif
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
                                columns: [ 0, 1 ,2,3,4,5,6,7,8,9]
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
