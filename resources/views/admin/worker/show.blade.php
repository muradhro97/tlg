@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.workers'),'url'=>'worker'])
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
                <a class="btn btn-outline btn-primary" target="_blank"
                   href="{{url('admin/worker-print-details/'.$row->id)}}"><i
                        class="fa fa-print"></i> {{trans('main.print')}}
                </a>
            </div>
            <div class="pull-left">
                <a class="btn btn-outline btn-warning" target="_blank" href="{{url('admin/worker-print/'.$row->id)}}"><i
                        class="fa fa-print"></i> {{trans('main.print_id_card')}}
                </a>
            </div>
        </div>
    </div>

    <div class="row m-b-lg m-t-lg">
        <div class="col-md-5">
            <div class="profile-image">
                <img src="{{url($row->image_thumb ?? 'assets/admin/img/broken.png')}}"
                     class="img-circle circle-border m-b-md" alt="profile">
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
                                    @can('editWor')
                                        <a href="{{url('admin/worker/'.$row->id.'/edit')}}"
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

                                    <dt>{{trans('main.department')}}:</dt>
                                    <dd> @if($row->department)<a
                                            href="{{url('admin/labors-department/'.$row->department->id.'/edit')}}"
                                            class="text-navy"> {{$row->department->name ?? '...'}}</a>@endif</dd>
                                    {{--<dt>{{trans('main.university')}}:</dt>--}}
                                    {{--<dd> @if($row->university)<a--}}
                                    {{--href="{{url('admin/university/'.$row->university->id.'/edit')}}"--}}
                                    {{--class="text-navy"> {{$row->university->name }}</a> @endif</dd>--}}

                                </dl>
                            </div>
                            <div class="col-lg-7" id="cluster_info">
                                <dl class="dl-horizontal">

                                    <dt>{{trans('main.nationality_no')}}:</dt>
                                    <dd>{{$row->nationality_no}}</dd>
                                    <dt>{{trans('main.bank_account')}}:</dt>
                                    <dd>{{$row->bank_account}}</dd>


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
                        <a href="{{url('admin/worker-time-sheet-history?worker_id='.$row->id)}}"
                           class="btn btn-success pull-right m-l-lg">{{trans('main.more')}}</a>
                        <h2>{{trans('main.worker_time_sheet')}}</h2>


                        @if($time_sheet->count()>0)
                            <div class="table-responsive">
                                <table class="data-table table table-bordered">
                                    <thead>
                                    <th>#</th>
                                    <th>{{trans('main.date') }}</th>
                                    <th>{{trans('main.attendance') }}</th>
                                    {{--                                    <th>{{trans('main.worker') }}</th>--}}
                                    <th data-hide="all">{{trans('main.project') }}</th>
                                    <th data-hide="all">{{trans('main.organization') }}</th>
                                    <th data-hide="all">{{trans('main.department') }}</th>
                                    {{--                        <th>{{trans('main.attendance') }}</th>--}}
                                    <th>{{trans('main.overtime') }}</th>
                                    <th>{{trans('main.deduction_hrs') }}</th>
                                    <th>{{trans('main.deduction_value') }}</th>
                                    <th>{{trans('main.safety') }}</th>
                                    <th>{{trans('main.additions') }}</th>
                                    <th>{{trans('main.discounts') }}</th>
                                    <th>{{trans('main.total') }}</th>


                                    </thead>
                                    <tbody>

                                    @foreach($time_sheet as $t)

                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$t->date}}</td>
                                            <td>{{$t->attendance}}</td>
                                            {{--                                            <td>{{$t->worker->name ?? ''}}</td>--}}
                                            <td>{{$t->worker->project->name ?? ''}}</td>
                                            <td>{{$t->worker->organization->name ?? ''}}</td>
                                            <td>{{$t->worker->department->name ?? ''}}</td>
                                            {{--                                <td>{{$t->attendance}}</td>--}}
                                            <td>{{$t->overtime}}</td>
                                            <td>{{$t->deduction_hrs}}</td>
                                            <td>{{$t->deduction_value}}</td>
                                            <td>{{$t->safety}}</td>
                                            <td>{{$t->additions}}</td>
                                            <td>{{$t->discounts}}</td>
                                            <td>{{$t->total}}</td>


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
                        <h2>{{trans('main.history')}}</h2>


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
                        <h2>{{trans('main.salaries')}}</h2>


                        @if($salaries->count()>0)
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
                                    <th>{{trans('main.loans') }}</th>
                                    <th>{{trans('main.taxes') }}</th>
                                    <th>{{trans('main.insurance') }}</th>
                                    <th>{{trans('main.net') }}</th>

                                    </thead>
                                    <tbody>

                                    @foreach($salaries as $r)

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
                                            <td>{{number_format($r->loans,2)}}</td>
                                            <td>{{number_format($r->taxes,2)}}</td>
                                            <td>{{number_format($r->insurance,2)}}</td>
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
@endpush
