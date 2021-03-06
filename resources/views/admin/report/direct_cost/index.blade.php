@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.direct_cost'),'url'=>'reports/direct_cost'])
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
            <h5>{{trans('main.direct_cost') }}</h5>
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
            <span class="btn btn-flat  btn-primary btn-md">
                <a class="text-white" href="{{url('admin/reports/direct_cost/worker_salaries')}}">{{trans('main.worker_salaries')}}</a>
            </span>

            <span class="btn btn-flat  btn-primary btn-md">
                <a class="text-white" href="{{url('admin/reports/direct_cost/invoices')}}">{{trans('main.invoices')}}</a>
            </span>

            <span class="btn btn-flat  btn-primary btn-md">
                <a class="text-white" href="{{url('admin/reports/direct_cost/extracts')}}">{{trans('main.extracts')}}</a>
            </span>
            <div class="main-content">
                <div class="header    pb-8 pt-5 pt-md-8">
                    <div class="container-fluid">
                        <h2 class="mb-5">{{trans('main.total')}}</h2>
                        <div class="header-body">
                            <div class="row_statistics">
                                <div class="col-xl-3 col-lg-6">
                                    <div class="card card-stats mb-4 mb-xl-0">
                                        <div class="card-body">
                                            <div class="row_statistics">
                                                <div class="col">
                                                    <h5 class="card-title text-uppercase text-muted mb-0">{{trans('main.salaries')}}</h5>
                                                    <span class="h1 font-weight-bold mb-0">{{number_format($salaries,2)}}</span>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                                        <i class="fa fa-bank"></i>
                                                    </div>
                                                </div>
                                            </div>
{{--                                            <p class="mt-3 mb-0 text-muted text-sm">--}}
{{--                                                <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>--}}
{{--                                                <span class="text-nowrap">Since last month</span>--}}
{{--                                            </p>--}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-6">
                                    <div class="card card-stats mb-4 mb-xl-0">
                                        <div class="card-body">
                                            <div class="row_statistics">
                                                <div class="col">
                                                    <h4 class="card-title text-uppercase text-muted mb-0">{{trans('main.invoices')}}</h4>
                                                    <span class="h1 font-weight-bold mb-0">{{number_format($invoices,2)}}</span>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                                        <i class="fa fa-file-text"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-6">
                                    <div class="card card-stats mb-4 mb-xl-0">
                                        <div class="card-body">
                                            <div class="row_statistics">
                                                <div class="col">
                                                    <h4 class="card-title text-uppercase text-muted mb-0">{{trans('main.extracts')}}</h4>
                                                    <span class="h1 font-weight-bold mb-0">{{number_format($extracts,2)}}</span>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                                        <i class="fa fa-file-excel-o"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-6">
                                    <div class="card card-stats mb-4 mb-xl-0">
                                        <div class="card-body">
                                            <div class="row_statistics">
                                                <div class="col">
                                                    <h4 class="card-title text-uppercase text-muted mb-0">{{trans('main.total')}}</h4>
                                                    <span class="h1 font-weight-bold mb-0">{{number_format($total,2)}}</span>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                                        <i class="fa fa-dollar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Page content -->
                <div class="row">
                    <div class="col-md-12">
                            <div class="table-responsive">

                                <table class="data-table table table-bordered myTable">
                                    <thead>
                                    <th>{{trans('main.salaries') }}</th>
                                    <th>{{trans('main.invoices') }}</th>
                                    <th>{{trans('main.extracts') }}</th>
                                    <th>{{trans('main.total') }}</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{number_format($salaries,2)}}</td>
                                            <td>{{number_format($invoices,2)}}</td>
                                            <td>{{number_format($extracts,2)}}</td>
                                            <td>{{number_format($total,2)}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            {{--                        <div class="text-center">--}}
                            {{--                            {!! $funding_rows->appends(request()->except('page'))->links() !!}--}}
                            {{--                        </div>--}}
                        <div class="clearfix"></div>
                    </div>
                </div>
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
