@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.worker_salary'),'url'=>'reports/direct_cost'])
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
            <h5>{{trans('main.worker_salary') }}</h5>
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
                            <th>#</th>
                            <th>{{trans('main.id') }}</th>
                            <th>{{trans('main.name') }}</th>
                            {{--                        <th>{{trans('main.contract_type') }}</th>--}}
                            {{--                        <th>{{trans('main.custody_transaction_no') }}</th>--}}
                            <th>{{trans('main.days') }}</th>
                            <th>{{trans('main.current_daily_salary') }}</th>
                            <th>{{trans('main.daily_salary') }}</th>
                            <th>{{trans('main.overtime') }}({{trans('main.hours')}})</th>
                            <th>{{trans('main.current_hourly_salary') }}</th>
                            <th>{{trans('main.additions') }}</th>
                            <th>{{trans('main.deduction_hrs') }}</th>
                            <th>{{trans('main.deduction_value') }}</th>
                            <th>{{trans('main.safety') }}</th>
                            <th>{{trans('main.discounts') }}</th>
                            <th>{{trans('main.total') }}</th>
{{--                            <th>{{trans('main.loans') }}</th>--}}
{{--                            <th>{{trans('main.taxes') }}</th>--}}
{{--                            <th>{{trans('main.insurance') }}</th>--}}
{{--                            <th>{{trans('main.net') }}</th>--}}

                            </thead>
                            <tbody>
                            <?php
                                $sum_daily_salary =0;
                                $sum_daily_salary =0;
                                $sum_daily_salary =0;
                            ?>
                            @foreach($rows as $r)

                                <tr>
                                    <td>{{ $loop->iteration}}</td>
                                    {{--                                <td>{{$row->id}}</td>--}}
                                    <td>{{$r->worker->id}}</td>
                                    <td>{{$r->worker->name}}</td>
                                    <td>{{$r->days}}</td>
                                    <td>{{number_format($r->worker->job->daily_salary ?? 0,2)}}</td>
                                    <td>{{number_format($r->daily_salary,2)}}</td>
                                    <td>{{$r->overtime}}</td>
                                    <td>{{number_format($r->worker->job->hourly_salary ?? 0,2)}}</td>
                                    <td>{{number_format($r->additions,2)}}</td>
                                    <td>{{$r->deduction_hrs}}</td>
                                    <td>{{number_format($r->deduction_value,2)}}</td>
                                    <td>{{$r->safety}}</td>
                                    <td>{{number_format($r->discounts,2)}}</td>
                                    <td>{{number_format($r->total,2)}}</td>
{{--                                    <td>{{number_format($r->loans,2)}}</td>--}}
{{--                                    <td>{{number_format($r->taxes,2)}}</td>--}}
{{--                                    <td>{{number_format($r->insurance,2)}}</td>--}}
{{--                                    <td>{{number_format($r->net,2)}}</td>--}}


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
                                    <td>TOTAL</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>{{number_format($rows->sum('daily_salary'),2)}}</td>
                                    <td>{{number_format($rows->sum('overtime'),2)}}</td>
                                    <td></td>
                                    <td>{{number_format($rows->sum('additions'),2)}}</td>
                                    <td>{{number_format($rows->sum('deduction_hrs'),2)}}</td>
                                    <td>{{number_format($rows->sum('deduction_value'),2)}}</td>
                                    <td>{{number_format($rows->sum('safety'),2)}}</td>
                                    <td>{{number_format($rows->sum('discounts'),2)}}</td>
                                    <td>{{number_format($rows->sum('total'),2)}}</td>
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
