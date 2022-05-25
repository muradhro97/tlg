@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.employees'),'url'=>'employee'])
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
                <div class="col-sm-3">
                    <div class="form-group "
                         id="start_date_wrap">
                        <label for="date"> {{trans('main.date')}}</label>

                        {{--<input type="text" class="form-control">--}}
                        <div class="input-group date ">
                            {{Form::text('date', request()->date, [
                                            "placeholder" => trans('main.date'),
                                            "class" => "form-control datepicker2",

                                        ]) }}
                            {{--<input type="text" name="start_date" class="  form-control" id="filter-from"--}}
                            {{--value="" placeholder="من">--}}
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 text-center">
                    <div class="col-sm-12">
                        <div class="col-sm-6">
                            <label class="control-label" for="from">{{trans('main.from')}}</label>
                            <div class="input-group clockpicker" data-autoclose="true">
                                <input type="date" name="from" class="form-control"
                                       placeholder="{{trans('main.from')}}" value="{{old('from')}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="control-label" for="to">{{trans('main.to')}}</label>
                            <div class="input-group clockpicker" data-autoclose="true">
                                <input type="date" name="to" class="form-control"
                                       placeholder="{{trans('main.to')}}" value="{{old('to')}}">
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

    <div class="ibox-content m-b-sm border-bottom float-e-margins">

        <div class="row">
            <div class="pull-right">
                <a class="btn btn-outline btn-primary" target="_blank" href="{{url('admin/employee-print-details/'.$row->id)}}"><i class="fa fa-print"></i>  {{trans('main.print')}}
                </a>




            </div>

            <div class="pull-left">
                <a class="btn btn-outline btn-warning" target="_blank" href="{{url('admin/employee-print/'.$row->id)}}"><i
                            class="fa fa-print"></i> {{trans('main.print_id_card')}}
                </a>
            </div>

        </div>

    </div>
    <div class="row m-b-lg m-t-lg">
        <div class="col-md-5">

            <div class="profile-image">
                <img src="{{url($row->image_thumb ?? 'assets/admin/img/broken.png')}}" class="img-circle circle-border m-b-md" alt="profile">
            </div>
            <div class="profile-info">
                <div class="">
                    <div>
                        <h2 class="no-margins">
                            {{$row->name}}
                        </h2>
                        <h4>{{$row->job->name ?? ''}}</h4>
                        <small>
                            {{$row->address}}
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <table class="table small m-b-xs">
                <tbody>
                <tr>
                    <td>
                        <strong><i class="fa fa-envelope-o"></i> </strong> {{$row->email}}
                    </td>
                    <td>
                        <strong> <i class="fa fa-phone"></i></strong> {{$row->mobile}}
                    </td>

                </tr>
                <tr>
                    <td>
                        <strong><i class="fa fa-briefcase"></i></strong> {{$row->organization->name ?? ''}}
                    </td>
                    <td>
                        <strong><i class="fa fa-building-o"></i></strong> {{$row->project->name ?? ''}}
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong><i class="fa  fa-birthday-cake"></i></strong> {{$row->birth_date}}
                    </td>
                    <td>
                        <strong><i class="fa fa-male"></i></strong> {{$row->gender_display}}
                    </td>
                </tr>

                </tbody>
            </table>
        </div>

        <div class="col-md-2">
            {!! QrCode::size(100)->generate("http://hatem-goda.com/tlg"); !!}
        </div>
        {{--<div class="col-md-2">--}}
            {{--<small>Performance evaluation</small>--}}
            {{--<h2 class="no-margins">206 480</h2>--}}
            {{--<div id="sparkline1"></div>--}}
        {{--</div>--}}


    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content animated fadeInUp">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="m-b-md">
                                    @can('editEmp')
                                    <a href="{{url('admin/employee/'.$row->id.'/edit')}}"
                                       class="btn btn-outline btn-primary  pull-right">{{trans('main.edit')}}</a>
                                    @endcan
                                    <h2>{{trans('main.details')}}</h2>
                                </div>
                                <dl class="dl-horizontal">
                                    <dt>{{trans('main.working_status')}}:</dt>
                                    <dd><span class="label label-primary">{{$row->working_status_display}}</span></dd>
                                </dl>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5">
                                <dl class="dl-horizontal">


                                    <dt>{{trans('main.nationality')}}:</dt>
                                    <dd> @if($row->country)<a href="{{url('admin/country/'.$row->country->id.'/edit')}}"
                                                              class="text-navy"> {{$row->country->nationality}}</a>@endif
                                    </dd>
                                    <dt>{{trans('main.bank')}}:</dt>
                                    <dd> @if($row->bank)<a href="{{url('admin/bank/'.$row->bank->id.'/edit')}}"
                                                           class="text-navy"> {{$row->bank->name }}</a>@endif
                                    </dd>
                                    <dt>{{trans('main.university')}}:</dt>
                                    <dd> @if($row->university)<a
                                                href="{{url('admin/university/'.$row->university->id.'/edit')}}"
                                                class="text-navy"> {{$row->university->name }}</a> @endif</dd>

                                </dl>
                            </div>
                            <div class="col-lg-7" id="cluster_info">
                                <dl class="dl-horizontal">

                                    <dt>{{trans('main.nationality_no')}}:</dt>
                                    <dd>{{$row->nationality_no}}</dd>
                                    <dt>{{trans('main.bank_account')}}:</dt>
                                    <dd> {{$row->bank_account}}</dd>
                                    <dt>{{trans('main.department')}}:</dt>
                                    <dd>
                                        @if($row->department)<a
                                                href="{{url('admin/department/'.$row->department->id.'/edit')}}"
                                                class="text-navy"> {{$row->department->name ?? '...'}}</a>
                                        @endif
                                    </dd>


                                </dl>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">

                    <div class="ibox-content">

                        <h2>{{trans('main.documents')}}</h2>


                        <div class="lightBoxGallery">

                            @foreach($row->images as $image)
                                <a href="{{url($image->image)}}" title="Tlg" data-gallery=""><img
                                            src="{{url($image->image_thumb)}}"></a>
                        @endforeach
                        <!-- The Gallery as lightbox dialog, should be a child element of the document body -->
                            <div id="blueimp-gallery" class="blueimp-gallery">
                                <div class="slides"></div>
                                <h3 class="title"></h3>
                                <a class="prev">‹</a>
                                <a class="next">›</a>
                                <a class="close">×</a>
                                <a class="play-pause"></a>
                                <ol class="indicator"></ol>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">

                    <div class="ibox-content">
                        <a href="{{url('admin/employee-time-sheet-history?employee_id='.$row->id)}}"
                           class="btn btn-success pull-right m-l-lg">{{trans('main.more')}}</a>
                        <h2>{{trans('employee_time_sheet')}}</h2>


                        @if($time_sheet->count()>0)
                            <div class="table-responsive">
                                <table class="data-table table table-bordered">
                                    <thead>
                                    <th>#</th>
                                    <th>{{trans('main.date') }}</th>

                                    <th>{{trans('main.attendance') }}</th>
                                    <th>{{trans('main.period1_from') }}</th>
                                    <th>{{trans('main.period1_to') }}</th>
                                    <th>{{trans('main.period1_hrs') }}</th>
                                    <th>{{trans('main.period2_from') }}</th>
                                    <th>{{trans('main.period2_to') }}</th>
                                    <th>{{trans('main.period2_hrs') }}</th>
                                    <th>{{trans('main.total_daily') }}</th>
                                    <th>{{trans('main.overtime') }}</th>
                                    <th>{{trans('main.total_regular') }}</th>
                                    <th>{{trans('main.details') }}</th>


                                    </thead>
                                    <tbody>
                                    <?php

                                    ?>
                                    @foreach($time_sheet as $t)
                                        <tr style="{{!$t->attendance_color?'' : 'border:2px dashed '.$t->attendance_color.''}}">
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$t->date}}</td>

                                            <td>{{$t->attendance}}</td>
                                            <td>{{$t->from1}}</td>
                                            <td>{{$t->to1}}</td>
                                            <td>{{$t->hrs1}}</td>
                                            <td>{{$t->from2}}</td>
                                            <td>{{$t->to2}}</td>
                                            <td>{{$t->hrs2}}</td>
                                            <td>{{minToHour($t->total_daily_minutes)}}</td>
                                            <td>{{minToHour($t->overtime_minutes)}}</td>
                                            <td>{{minToHour($t->total_regular_minutes)}}</td>
                                            <td>{{$t->details}}</td>



                                        </tr>

                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                        @else
                            <h2 class="text-center">{{trans('main.no_records') }}</h2>
                        @endif

                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">

                    <div class="ibox-content">
                        <h2>History</h2>


                        @if($row->change_logs()->count()>0)
                            <div class="table-responsive">
                                <table class="data-table table table-bordered">
                                    <thead>
                                    <th>#</th>
                                    <th>{{trans('main.change_type') }}</th>
                                    <th>{{trans('main.Old Value') }}</th>
                                    <th>{{trans('main.New Value') }}</th>
                                    <th>{{trans('main.date') }}</th>
                                    {{--                                    <th>{{trans('main.worker') }}</th>--}}
                                    </thead>
                                    <tbody>

                                    @foreach($row->change_logs as $t)

                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$t->change_type}}</td>
                                            <td>{{$t->change_value??''}}</td>
                                            <td>{{$t->new_value??''}}</td>
                                            <td>{{$t->created_at}}</td>
                                        </tr>

                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                        @else
                            <h2 class="text-center">{{trans('main.no_records') }}</h2>
                        @endif

                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">

                    <div class="ibox-content">
                        <h2>Custody</h2>
                        <?php
                            $row_custody = clone $row;
                            $row_custody = $row_custody->custody->where('status', 'open');
                        ?>
                        @if($row_custody->count()>0)
                            <div class="table-responsive">
                                <table class="data-table table table-bordered print_table">
                                    <thead>
                                    <th>#</th>
                                    <th>{{trans('main.transaction_no') }}</th>
                                    <th>{{trans('main.type') }}</th>
                                    <th>{{trans('main.amount') }}</th>
                                    {{--                        <th>{{trans('main.custody_transaction_no') }}</th>--}}
                                    <th>{{trans('main.organization') }}</th>
                                    <th>{{trans('main.project') }}</th>
                                    <th>{{trans('main.employee') }}</th>
                                    {{--<th>{{trans('main.safe_balance') }}</th>--}}
                                    {{--<th>{{trans('main.safe_new_balance') }}</th>--}}
                                    <th>{{trans('main.payment_status') }}</th>
                                    <th>{{trans('main.status') }}</th>
                                    @canany(['detailsPayment','custodyRest'])
                                        <th>{{trans('main.options') }}</th>
                                    @endcanany
                                    {{--<th class="text-center">{{trans('main.edit') }}</th>--}}
                                    {{--<th class="text-center">{{trans('main.delete') }}</th>--}}
                                    </thead>
                                    <tbody>
                                    @php $count = 1; @endphp
                                    @foreach($row_custody as $i)
                                        <?php
                                        $iteration = $loop->iteration
                                        ?>
                                        <tr>
                                            <td>{{$iteration}}</td>
                                            <td>{{$i->id}}</td>
                                            <td>{{$i->type}}</td>
                                            <td>{{$i->amount}}</td>
                                            {{--                                <td>{{$row->safe_transaction_id ?? ''}}</td>--}}
                                            <td>{{$i->organization->name ?? ''}}</td>
                                            <td>{{$i->project->name ?? ''}}</td>
                                            <td>{{$i->employee->name ?? ''}}</td>
                                            {{--<td>{{$row->balance}}</td>--}}
                                            {{--<td>{{$row->new_balance}}</td>--}}
                                            <td>{{$i->payment_status}}</td>
                                            <td>{{$i->status}}</td>
                                            @canany(['detailsPayment','custodyRest'])
                                                <td>
                                                    @can('custodyRest')
                                                        @if($i->type=="custody" and $i->status== "open"  and $i->payment_status == 'paid')

                                                            <a type="button" href="{{url('admin/custody-rest/'.$i->id)}}"
                                                               class="btn btn-sm btn-primary"><i
                                                                    class="fa fa-retweet"></i> {{trans('main.rest')}}</a>




                                                        @endif
                                                    @endcan
                                                    @can('detailsPayment')
                                                        <a style="margin: 2px;" type="button" href="{{url('admin/payment/'.$i->id)}}"
                                                           class="btn btn-sm btn-primary"><i
                                                                class="fa fa-eye"></i></a>

                                                    @endcan
                                                </td>
                                            @endcan
                                        </tr>
                                        @php $count ++; @endphp
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <h2 class="text-center">{{trans('main.no_records') }}</h2>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">

                    <div class="ibox-content">
                        <h2>Loans</h2>

                        <?php
                            $loans = $row->loans()->whereNull('accounting_id')->paginate(10);
                        ?>
                        @if($loans->count()>0)

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
                                    <table class="data-table table table-bordered print_table">
                                        <thead>
                                        <th>#</th>
                                        <th>{{trans('main.id') }}</th>
                                        <th>{{trans('main.type') }}</th>
                                        <th>{{trans('main.date') }}</th>
                                        <th>{{trans('main.amount') }}</th>
                                        {{--                        <th>{{trans('main.custody_transaction_no') }}</th>--}}

                                        <th>{{trans('main.safe') }}</th>
                                        <th>{{trans('main.employee') }}</th>
                                        {{--<th>{{trans('main.safe_balance') }}</th>--}}
                                        {{--<th>{{trans('main.safe_new_balance') }}</th>--}}
                                        <th>{{trans('main.manager_status') }}</th>
                                        <th>{{trans('main.payment_status') }}</th>
                                        @can('detailsEmployeeLoan')
                                            <th>{{trans('main.options') }}</th>
                                        @endcan
                                        {{--<th class="text-center">{{trans('main.edit') }}</th>--}}
                                        {{--<th class="text-center">{{trans('main.delete') }}</th>--}}
                                        </thead>
                                        <tbody>
                                        @php $count = 1; @endphp
                                        @foreach($loans as $row)
                                            <?php
                                            $iteration = $loop->iteration + (($loans->currentPage() - 1) * $loans->perPage())
                                            ?>
                                            <tr>
                                                <td>
                                                    @if($row->type=="employeeLoan" and $row->manager_status=="waiting"  )
                                                        <input type="checkbox" value="{{$row->id}}" name="ids[]">
                                                    @endif
                                                </td>
                                                <td>{{$row->id}}</td>
                                                <td>{{$row->type}}</td>
                                                <td>{{$row->date}}</td>
                                                <td>{{$row->amount}}</td>
                                                {{--                                <td>{{$row->safe_transaction_id ?? ''}}</td>--}}

                                                <td>{{$row->safe->name ?? ''}}</td>
                                                <td>{{$row->employee->name ?? ''}}</td>
                                                {{--<td>{{$row->balance}}</td>--}}
                                                {{--<td>{{$row->new_balance}}</td>--}}
                                                <td>{{$row->manager_status}}</td>
                                                <td>{{$row->payment_status}}</td>
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
                                    </table>
                                </div>
                            </form>
                            <div class="text-center">
                                {!! $loans->appends(request()->except('page'))->links() !!}
                            </div>
                        @else
                            <h2 class="text-center">{{trans('main.no_records') }}</h2>
                        @endif

                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">

                    <div class="ibox-content">
                        <h2>{{trans('main.salaries')}}</h2>


                        @if($salaries->count()>0)
                            <div class="table-responsive">
                                <table class="data-table table table-bordered">
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
                                        <th rowspan="2">{{trans('main.loans') }}</th>
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

                                    @foreach($salaries as $r)

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
                                            <td>{{number_format($r->loans,2)}}</td>

                                            <td>{{number_format($r->net,2)}}</td>


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

        </div>
    </div>

@stop
@push('style')
    <link rel="stylesheet" type="text/css"
          href="{{asset('assets/admin/plugins/blueimp/css/blueimp-gallery.min.css')}}"/>


@endpush
@push('script')
    {{--<script src="{{asset('assets/admin/plugins/sparkline/jquery.sparkline.min.js')}}"></script>--}}
    <script src="{{asset('assets/admin/plugins/blueimp/js/jquery.blueimp-gallery.min.js')}}"></script>
    {{--<script>--}}
        {{--$(document).ready(function () {--}}


            {{--$("#sparkline1").sparkline([34, 43, 43, 35, 44, 32, 44, 48], {--}}
                {{--type: 'line',--}}
                {{--width: '100%',--}}
                {{--height: '50',--}}
                {{--lineColor: '#1ab394',--}}
                {{--fillColor: "transparent"--}}
            {{--});--}}


        {{--});--}}
    {{--</script>--}}

    <script>
        $(".datepicker2").datepicker({
            currentText: "{{trans('main.current_month')}}",
            closeText: "{{trans('main.select')}}",
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            changeDay: true,
            dateFormat: 'MM yy',
//                isRTL: true,
            onClose: function (dateText, inst) {
                $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
            }

        });
    </script>
@endpush
