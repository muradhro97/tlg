@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.invoices'),'url'=>'reports/direct_cost'])
@stop
@section('content')

    @inject('project','App\Project')

    <?php

    $projects = $project->oldest()->pluck('name', 'id')->toArray();

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
                        {{Form::select('project_id', $projects, request()->project_id, [
                            "class" => "form-control select2 " ,
                            "id" => "project_id",
                            "placeholder" => trans('main.project')
                        ])}}
                    </div>
                </div>
                <div class="col-sm-4 text-center p-xxs">
                    <div class="col-sm-12 p-xxs">
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
            <div class="row mt-3">
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
            <h5>{{trans('main.invoices') }}</h5>
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
            <div>
                @if($rows->count() > 0)
                    <div class="table-responsive">
                        <table class="data-table table table-bordered myTable">
                            <thead>
                            <th>#</th>
                            <th>{{trans('main.id') }}</th>
                            <th>{{trans('main.amount') }}</th>
                            <th>{{trans('main.date') }}</th>
                            {{--                        <th>{{trans('main.custody_transaction_no') }}</th>--}}
{{--                            <th>{{trans('main.project') }}</th>--}}
                            <th>{{trans('main.organization') }}</th>
                            {{--                        <th>{{trans('main.labors_type') }}</th>--}}
                            <th>{{trans('main.labors_department') }}</th>
                            {{--                        <th>{{trans('main.labors_type') }}</th>--}}
                            {{--                        <th>{{trans('main.contract') }}</th>--}}
                            <th>{{trans('main.safe') }}</th>
                            <th>{{trans('main.submitted_by') }}</th>
                            {{--<th>{{trans('main.safe_balance') }}</th>--}}
                            {{--<th>{{trans('main.safe_new_balance') }}</th>--}}
                            @can('detailsInvoice')
                                <th>{{trans('main.options') }}</th>
                            @endcan
{{--                            <th>{{trans('main.loans') }}</th>--}}
{{--                            <th>{{trans('main.taxes') }}</th>--}}
{{--                            <th>{{trans('main.insurance') }}</th>--}}
{{--                            <th>{{trans('main.net') }}</th>--}}

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
                                    <td>{{number_format($row->amount,2)}}</td>
                                    <td>{{$row->date}}</td>
                                    {{--                                <td>{{$row->safe_transaction_id ?? ''}}</td>--}}
{{--                                    <td>{{$row->project->name ?? ''}}</td>--}}
                                    <td>{{$row->organization->name ?? ''}}</td>
                                    <td>{{$row->laborsDepartment->name ?? ''}}</td>
                                    {{--                                <td>{{$row->labors_type}}</td>--}}
                                    {{--                                <td>{{$row->contract->no ?? ''}}</td>--}}
                                    <td>{{$row->safe->name ?? ''}}</td>
                                    <td>{{$row->employee->name ?? ''}}</td>
                                    {{--<td>{{$row->balance}}</td>--}}
                                    {{--<td>{{$row->new_balance}}</td>--}}
                                    @can('detailsInvoice')
                                        <td>

                                            <a style="margin: 2px;" type="button" href="{{url('admin/invoice/'.$row->id)}}"
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
                            @endforeach                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan=2">TOTAL</td>
                                    <td></td>
                                    <td>{{number_format($total,2)}}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>

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
            </div>
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
                                columns: [ 0, 1 ,2,3,4,5,6,7,8]
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
