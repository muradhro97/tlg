@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.organization cred/debt'),'url'=>'reports/organizations'])
@stop
@section('content')
{{--    <div class="ibox ibox-primary">--}}
{{--        <div class="ibox-title">--}}
{{--            <h5>{{trans('main.search') }}</h5>--}}
{{--            <div class="ibox-tools">--}}
{{--                <a class="collapse-link">--}}
{{--                    <i class="fa fa-chevron-up"></i>--}}
{{--                </a>--}}
{{--                <a class="close-link">--}}
{{--                    <i class="fa fa-times"></i>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="ibox-content m-b-sm border-bottom">--}}

{{--            {!! Form::open([--}}
{{--                  'method' => 'GET'--}}
{{--              ]) !!}--}}
{{--            <div class="row">--}}
{{--                <div class="col-sm-4">--}}
{{--                    <div class="form-group">--}}
{{--                        <label class="control-label" for="name">{{trans('main.name') }}</label>--}}
{{--                        <input type="text" id="name" name="name" value="{{request()->name}}"--}}
{{--                               placeholder="{{trans('main.name') }}"--}}
{{--                               class="form-control">--}}
{{--                    </div>--}}
{{--                </div>--}}


{{--            </div>--}}
{{--            <div class="clearfix"></div>--}}
{{--            <div class="row">--}}
{{--                <div class="col-sm-2 ">--}}
{{--                    <div class="form-group">--}}
{{--                        <label for="">&nbsp;</label>--}}
{{--                        <button type="submit"--}}
{{--                                class="btn btn-flat  btn-primary btn-md">{{trans('main.search') }}</button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            {!! Form::close() !!}--}}
{{--        </div>--}}
{{--    </div>--}}
    <div class="ibox ibox-primary">
        <div class="ibox-title">
            <h5>{{trans('main.organization cred/debt') }} | {{$organization->name}}</h5>
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

            <div class="clearfix"></div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <h4>{{trans('main.extracts') }}</h4>

                    @if($extracts->count()>0)

                        <div class="table-responsive">

                            <table class="data-table table table-bordered myTable">
                                <thead>
                                <th>#</th>
                                <th>{{trans('main.date') }}</th>
                                <th>{{trans('main.sub_contract') }}</th>
                                <th>{{trans('main.contract_type') }}</th>
                                <th>{{trans('main.project') }}</th>
                                <th>{{trans('main.period_from') }}</th>
                                <th>{{trans('main.period_to') }}</th>
                                <th>{{trans('main.contract_value') }}</th>
                                </thead>
                                <tbody>
                                @foreach($extracts as $row)
                                    <?php
                                    $iteration = $loop->iteration
                                    ?>
                                    <tr>
                                        <td>{{$iteration}}</td>
                                        <td>{{$row->date}}</td>
                                        <td>{{$row->subContract->no ?? ''}}</td>
                                        <td>{{$row->subContract->contractType->name ?? ''}}</td>
                                        <td>{{$row->project->name ?? ''}}</td>
                                        <td>{{$row->period_from}}</td>
                                        <td>{{$row->period_to}}</td>
                                        <td>{{number_format($row->total,2)}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="7">{{trans('main.total')}}</td>
                                    <td>{{number_format($extracts->sum('total'),2)}}</td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        {{--                        <div class="text-center">--}}
                        {{--                            {!! $funding_rows->appends(request()->except('page'))->links() !!}--}}
                        {{--                        </div>--}}
                    @else
                        <h2 class="text-center">{{trans('main.no_records') }}</h2>
                    @endif
                    <div class="clearfix"></div>
                </div>
                @if($organization->type == 'subContractor')
                <div class="col-md-6">
                    <h4>{{trans('main.cash_out') }}</h4>


                    @if($rows->count()>0)

                        <div class="table-responsive">

                            <table class="data-table table table-bordered myTable">
                                <thead>
                                <th>#</th>
                                <th>{{trans('main.transaction_no') }}</th>
                                <th>{{trans('main.project') }}</th>
                                <th>{{trans('main.employee') }}</th>
                                <th>{{trans('main.payment_status') }}</th>
                                <th>{{trans('main.status') }}</th>
                                <th>{{trans('main.amount') }}</th>
                                </thead>
                                <tbody>
                                @foreach($rows as $row)
                                    <?php
                                    $iteration = $loop->iteration
                                    ?>
                                    <tr>
                                        <td>{{$iteration}}</td>
                                        <td>{{$row->id}}</td>
                                        <td>{{$row->project->name ?? ''}}</td>
                                        <td>{{$row->employee->name ?? ''}}</td>
                                        <td>{{$row->payment_status}}</td>
                                        <td>{{$row->status}}</td>
                                        <td>{{number_format($row->amount,2)}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="6">{{trans('main.total')}}</td>
                                    <td>{{number_format($rows->sum('amount'),2)}}</td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        {{--                            <div class="text-center">--}}
                        {{--                                    {!! $extract_rows->appends(request()->except('page'))->links() !!}--}}
                        {{--                            </div>--}}
                    @else
                        <h2 class="text-center">{{trans('main.no_records') }}</h2>
                    @endif
                    <div class="clearfix"></div>
                </div>
                @else
                    <div class="col-md-6">
                        <h4>{{trans('main.actual_cash_in') }}</h4>


                        @if($rows->count()>0)

                            <div class="table-responsive">

                                <table class="data-table table table-bordered myTable">
                                    <thead>
                                    <th>#</th>
                                    <th>{{trans('main.id') }}</th>
                                    <th>{{trans('main.date') }}</th>
                                    <th>{{trans('main.project') }}</th>
                                    <th>{{trans('main.transaction_cheque_no') }}</th>
                                    <th>{{trans('main.contract') }}</th>
                                    <th>{{trans('main.safe') }}</th>
                                    <th>{{trans('main.submitted_by') }}</th>
                                    <th>{{trans('main.amount') }}</th>
                                    </thead>
                                    <tbody>
                                    @foreach($rows as $row)
                                        <?php
                                        $iteration = $loop->iteration
                                        ?>
                                        <tr>
                                            <td>{{$iteration}}</td>
                                            <td>{{$row->id}}</td>
                                            <td>{{$row->date}}</td>
                                            <td>{{$row->project->name ?? ''}}</td>
                                            <td>{{$row->transaction_cheque_no}}</td>
                                            <td>{{$row->contract->no ?? ''}}</td>
                                            <td>{{$row->safe->name ?? ''}}</td>
                                            <td>{{$row->employee->name ?? ''}}</td>
                                            <td>{{number_format($row->amount,2)}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="8">{{trans('main.total')}}</td>
                                        <td>{{number_format($rows->sum('amount'),2)}}</td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            {{--                            <div class="text-center">--}}
                            {{--                                    {!! $extract_rows->appends(request()->except('page'))->links() !!}--}}
                            {{--                            </div>--}}
                        @else
                            <h2 class="text-center">{{trans('main.no_records') }}</h2>
                        @endif
                        <div class="clearfix"></div>
                    </div>
                @endif
            </div>

        </div>
    </div>

@stop
