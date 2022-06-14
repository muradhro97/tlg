@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.expenses'),'url'=>'reports/direct_cost'])
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
            <h5>{{trans('main.expenses_grouped') }}</h5>
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
                            <th>{{trans('main.expense_item')}}</th>
                            <th>{{trans('main.total')}}</th>
                            {{--                            <th>{{trans('main.loans') }}</th>--}}
                            {{--                            <th>{{trans('main.taxes') }}</th>--}}
                            {{--                            <th>{{trans('main.insurance') }}</th>--}}
                            {{--                            <th>{{trans('main.net') }}</th>--}}

                            </thead>
                            <tbody>
                            @foreach($grouped_rows as $index => $row)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>{{$row->expenseItem->name ?? ''}}</td>
                                    <td>{{number_format($row->total,2)}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="2">TOTAL</td>
                                <td>{{number_format($total_grouped,2)}}</td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                @else
                    <h2 class="text-center">{{trans('main.no_records') }}</h2>
                @endif
            </div>
        </div>
    </div>

    <div class="ibox ibox-primary">
        <div class="ibox-title">
            <h5>{{trans('main.expenses') }}</h5>
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
                            <th>{{trans('main.expense_item')}}</th>
                            <th>{{trans('main.item_name')}}</th>
                            <th>{{trans('main.quantity')}}</th>
                            <th>{{trans('main.price')}}</th>
                            <th>{{trans('main.total')}}</th>
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
                                $iteration = $loop->iteration + 1
                                ?>
                                <tr>
                                    <td>{{$iteration}}</td>
                                    <td>{{$row->expenseItem->name ?? ''}}</td>
                                    <td>{{$row->item_name}}</td>
                                    <td>{{number_format($row->quantity)}}</td>
                                    <td>{{$row->price}}</td>
                                    <td>{{ number_format($row->price * $row->quantity,2, '.', '')}}</td>
                                    @can('detailsInvoice')
                                        <td>

                                            <a style="margin: 2px;" type="button" href="{{url('admin/invoice/'.$row->accounting->id)}}"
                                               class="btn btn-sm btn-primary"><i
                                                    class="fa fa-eye"></i></a>
                                        </td>

                                    @endcan
                                </tr>
                                @php $count ++; @endphp
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5">TOTAL</td>
                                    <td>{{number_format($total,2)}}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
{{--                    <div class="text-center">--}}
{{--                        {!! $rows->appends(request()->except('page'))->links() !!}--}}
{{--                    </div>--}}
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
