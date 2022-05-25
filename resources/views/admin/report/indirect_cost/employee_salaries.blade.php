@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.employee_salary'),'url'=>'reports/direct_cost'])
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
            <div class="clea{{----}}rfix"></div>
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
            <h5>{{trans('main.employee_salary') }}</h5>
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
            <div class="row">

                @if($rows->count()>0)
                    <div class="table-responsive">
                        <table class="data-table table table-bordered myTable">
                            <thead>
                            <tr>
                                {{--<th colspan="10"></th>--}}
                                <th rowspan="2">#</th>

                                {{--                        <th>{{trans('main.transaction_no') }}</th>--}}
                                <th rowspan="2">{{trans('main.id') }}</th>
                                <th rowspan="2">{{trans('main.name') }}</th>
                                <th rowspan="2">{{trans('main.job') }}</th>
                                <th rowspan="2">{{trans('main.days') }}</th>
                                <th rowspan="2">{{trans('main.current_salary_per_hours') }}</th>
                                <th rowspan="2">{{trans('main.total_regular_hours') }}</th>
                                <th rowspan="2">{{trans('main.total_regular') }}</th>
                                <th rowspan="2">{{trans('main.total_overtime_hours') }}</th>
                                <th rowspan="2">{{trans('main.total_overtime') }}</th>
                                <th rowspan="2">{{trans('main.total_salary_hours') }}</th>
                                <th rowspan="2">{{trans('main.total_salary') }}</th>
                                <th rowspan="2">{{trans('main.rewards') }}</th>
                                <th colspan="3" rowspan="1"
                                    class="text-center">{{trans('main.allowances')}}</th>
                                <th colspan="3" rowspan="1"
                                    class="text-center">{{trans('main.deductions')}}</th>

                                <th rowspan="2">{{trans('main.monthly_evaluations') }}</th>
{{--                                <th rowspan="2">{{trans('main.loans') }}</th>--}}
                                <th rowspan="2">{{trans('main.net') }}</th>
                                {{--                            <th colspan="3">{{trans('main.deductions')}}</th>--}}
                                {{--<th colspan="1"></th>--}}
                            </tr>
                            <tr>


                                {{--<th rowspan="1" colspan="3">{{trans('main.aa') }}</th>--}}
                                <th rowspan="1">{{trans('main.meals') }}</th>
                                <th rowspan="1">{{trans('main.communications') }}</th>
                                <th rowspan="1">{{trans('main.transports') }}</th>
                                <th>{{trans('main.penalties') }}</th>
                                <th>{{trans('main.taxes') }}</th>
                                <th>{{trans('main.insurance') }}</th>

                            </tr>

                            </thead>
                            <tbody>
                            <?php
                                $sum_daily_salary =0;
                            ?>
                            @foreach($rows as $r)

                                <tr>
                                    <td>{{ $loop->iteration}}</td>
                                    {{--                                <td>{{$row->id}}</td>--}}
                                    <td>{{$r->employee->id}}</td>
                                    <td>{{$r->employee->name}}</td>
                                    <td>{{$r->employee->job->name ?? ''}}</td>
                                    <td>{{$r->days}}</td>
                                    <td>{{number_format($r->hourly_salary,2)}}</td>
                                    <td>{{$r->total_regular_minutes/60}}</td>
                                    <td>{{number_format($r->total_regular,2)}}</td>
                                    <td>{{$r->overtime_minutes/60}}</td>
                                    <td>{{number_format($r->overtime,2)}}</td>
                                    <td>{{$r->total_daily_minutes/60}}</td>
                                    <td>{{number_format($r->total_daily,2)}}</td>
                                    <td>{{number_format($r->rewards,2)}}</td>
                                    <td>{{number_format($r->meals,2)}}</td>
                                    <td>{{number_format($r->communications,2)}}</td>
                                    <td>{{number_format($r->transports,2)}}</td>
                                    <td>{{number_format($r->penalties,2)}}</td>


                                    <td>{{number_format($r->taxes,2)}}</td>
                                    <td>{{number_format($r->insurance,2)}}</td>
                                    <td>{{number_format($r->monthly_evaluations,2)}}</td>
{{--                                    <td>{{number_format($r->loans,2)}}</td>--}}

                                    <td>{{number_format($r->net + $r->loans,2)}}</td>


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
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>{{trans('main.total')}}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>{{$rows->sum('days')}}</td>
                                    <td>{{number_format($rows->sum('hourly_salary'),2)}}</td>
                                    <td>{{$rows->sum('total_regular_minutes')/60}}</td>
                                    <td>{{number_format($rows->sum('total_regular'),2)}}</td>
                                    <td>{{$rows->sum('overtime_minutes')/60}}</td>
                                    <td>{{number_format($rows->sum('overtime'),2)}}</td>
                                    <td>{{$rows->sum('total_daily_minutes')/60}}</td>
                                    <td>{{number_format($rows->sum('total_daily'),2)}}</td>
                                    <td>{{number_format($rows->sum('rewards'),2)}}</td>
                                    <td>{{number_format($rows->sum('meals'),2)}}</td>
                                    <td>{{number_format($rows->sum('communications'),2)}}</td>
                                    <td>{{number_format($rows->sum('transports'),2)}}</td>
                                    <td>{{number_format($rows->sum('penalties'),2)}}</td>
                                    <td>{{number_format($rows->sum('taxes'),2)}}</td>
                                    <td>{{number_format($rows->sum('insurance'),2)}}</td>
                                    <td>{{number_format($rows->sum('monthly_evaluations'),2)}}</td>
{{--                                    <td>{{number_format($rows->sum('loans'),2)}}</td>--}}
                                    <td>{{number_format($rows->sum('net') + $rows->sum('loans'),2)}}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="text-center">
                        {{--{!! $rows->appends(request()->except('page'))->links() !!}--}}
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
