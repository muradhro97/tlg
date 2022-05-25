@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.employee_monthly_evaluations'),'url'=>'employee-monthly-evaluation'])
@stop
@section('content')
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
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="name">{{trans('main.name') }}</label>
                        <input type="text" id="name" name="name" value="{{request()->name}}"
                               placeholder="{{trans('main.name') }}"
                               class="form-control">
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
            <h5>{{trans('main.employee_monthly_evaluations') }}</h5>
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
            @can('addEmpMonthlyEvaluation')
                <div class="">
                    <a href="{{url('admin/employee-monthly-evaluation/create')}}" class="btn btn-primary">
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
                        <th>{{trans('main.employee_name') }}</th>
                        <th>{{trans('main.date') }}</th>
                        {{--                        <th>{{trans('main.date') }}</th>--}}
                        <th>{{trans('main.monthly_evaluation_percentage') }}</th>
                        @can('editEmpMonthlyEvaluation')
                            <th class="text-center">{{trans('main.edit') }}</th>
                        @endcan
                        @can('deleteEmpMonthlyEvaluation')
                            <th class="text-center">{{trans('main.delete') }}</th>
                        @endcan
                        </thead>
                        <tbody>
                        @php $count = 1; @endphp
                        @foreach($rows as $row)
                            <?php
                            $iteration = $loop->iteration + (($rows->currentPage() - 1) * $rows->perPage())
                            ?>
                            <tr>
                                <td>{{$iteration}}</td>
                                <td>{{$row->employee->name ?? ''}}</td>
                                <td>{{\Carbon\Carbon::parse($row->date)->format('F Y')}}</td>
                                <td>{{$row->monthly_evaluation_percentage}}</td>
                                @can('editEmpMonthlyEvaluation')
                                    <td class="text-center">
                                        @if(!$row->accounting_id)
                                            <a href="{{url('admin/employee-monthly-evaluation/'.$row->id.'/edit')}}"
                                               class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a>
                                        @endif
                                    </td>
                                @endcan
                                @can('deleteEmpMonthlyEvaluation')
                                    <td class="text-center">
                                        @if(!$row->accounting_id)
                                            {{Form::open(array('method'=>'delete','class'=>'delete','url'=>url('admin/employee-monthly-evaluation/'.$row->id) )) }}
                                            <button type="submit" class="destroy btn btn-danger btn-xs"><i
                                                        class="fa fa-trash-o"></i></button>
                                            {{Form::close()}}
                                        @endif
                                    </td>
                                @endcan
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
                                columns: [ 0, 1 ,2,3,]
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