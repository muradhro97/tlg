@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.applicant_workers'),'url'=>'applicant-worker'])
@stop
@section('content')

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
                        <h4>{{$row->job->name ?? '...'}}</h4>
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
                        <strong><i class="fa fa-briefcase"></i></strong> {{$row->organization->name ?? '...'}}
                    </td>
                    <td>
                        <strong><i class="fa fa-building-o"></i></strong> {{$row->project->name ?? '...'}}
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
    @can('actionWorApp')

        <div class="ibox-content m-b-sm border-bottom float-e-margins">
            <!-- display errors of validation -->
            @include('partials.validation-errors')
            @include('flash::message')
            <div class="row">
                @if($row->evaluation_status== "wait" or $row->evaluation_status== "delay" )
                    <form method="post" action="{{route('acceptWorkerApplicant')}}" style="display: inline;">
                        {{csrf_field()}}
                        {{--<input type="hidden" name="status" value="warehouse">--}}
                        {{--<input type="hidden" name="statusaa" value="center">--}}
                        <input type="hidden" name="id" value="{{$row->id}}">
                        <button class="btn btn-info btn-outline " type="submit"><i
                                    class="fa fa-check"></i>&nbsp;{{trans('main.accept')}}
                        </button>

                    </form>
                    {{--<a class="btn btn-info btn-outline " href="{{url('admin/accept-employee-applicant/'.$row->id)}}"><i--}}
                                {{--class="fa fa-check"></i>&nbsp;{{trans('main.accept')}}--}}
                    {{--</a>--}}
                @endif
                @if($row->evaluation_status== "accept")
                    <form method="post" action="{{route('approveWorkerApplicant')}}" style="display: inline;">
                        {{csrf_field()}}
                        {{--<input type="hidden" name="status" value="warehouse">--}}
                        {{--<input type="hidden" name="statusaa" value="center">--}}
                        <input type="hidden" name="id" value="{{$row->id}}">
                        <button class="btn btn-primary btn-outline " type="submit"><i
                                    class="fa fa-check"></i>&nbsp;{{trans('main.approve')}}
                        </button>

                    </form>
                @endif
                @if($row->evaluation_status== "wait" or $row->evaluation_status== "delay" )
                    <div class="pull-right">
                        <button class="btn btn-warning btn-outline  " onclick="cancelOrder('delay')" type="button"><i
                                    class="fa fa-exclamation-circle"></i>&nbsp;{{trans('main.delay')}}
                        </button>
                        <button class="btn btn-danger btn-outline  " onclick="cancelOrder('reject')" type="button"><i
                                    class="fa fa-times"></i>{{trans('main.reject')}}
                        </button>
                    </div>
                @endif

            </div>

        </div>
    @endcan
    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content animated fadeInUp">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="m-b-md">
                                    @can('editWorApp')
                                    <a href="{{url('admin/applicant-worker/'.$row->id.'/edit')}}"
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
                                    <dt>{{trans('main.department')}}:</dt>
                                    <dd> @if($row->department)<a
                                                href="{{url('admin/labors-department/'.$row->department->id.'/edit')}}"
                                                class="text-navy"> {{$row->department->name ?? '...'}}</a>@endif</dd>

                                    <dt>{{trans('main.weight')}}:</dt>
                                    <dd>{{$row->weight_display}}</dd>
                                    <dt>{{trans('main.medical')}}:</dt>
                                    <dd>{{$row->medical_display}}</dd>

                                </dl>
                            </div>
                            <div class="col-lg-7" id="cluster_info">
                                <dl class="dl-horizontal">

                                    <dt>{{trans('main.nationality_no')}}:</dt>
                                    <dd>{{$row->nationality_no}}</dd>

                                    <dt>{{trans('main.technical')}}:</dt>
                                    <dd>{{$row->technical_display}}</dd>

                                    <dt>{{trans('main.mentality')}}:</dt>
                                    <dd>{{$row->mentality_display}}</dd>
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

                        <h2>Documents</h2>


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

    @include('admin.applicant_worker.show_modal')
@stop
@push('style')
    <link rel="stylesheet" type="text/css"
          href="{{asset('assets/admin/plugins/blueimp/css/blueimp-gallery.min.css')}}"/>


@endpush
@push('script')
{{--    <script src="{{asset('assets/admin/plugins/sparkline/jquery.sparkline.min.js')}}"></script>--}}
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