@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.applicant_workers'),'url'=>'applicant-worker'])
@stop
@section('content')
    @inject('job','App\Job')
    <?php
    $jobs = $job->latest()->where('type', 'worker')->pluck('name', 'id')->toArray();
    $evaluationStatusOptions = [


        'wait' => trans('main.wait'),
        'delay' => trans('main.delay'),
        'reject' => trans('main.reject'),
        'accept' => trans('main.accept'),
        'approve' => trans('main.approve'),

    ];
    ?>
    @can('addWorApp')
    <div class="">
        <a href="{{url('admin/applicant-worker/create')}}" class="btn btn-primary">
            <i class="fa fa-plus"></i> {{trans('main.new_applicant') }}
        </a>
    </div>

    @endcan
    <br>
    <div class="clearfix"></div>
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

                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="job_id">{{trans('main.job')}}</label>
                        {{Form::select('job_id', $jobs, request()->job_id, [
                            "class" => "form-control select2 " ,
                            "id" => "job_id",
                            "placeholder" => trans('main.job')
                        ])}}
                        {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="payment_status">{{trans('main.evaluation_status')}}</label>
                        {{Form::select('evaluation_status', $evaluationStatusOptions, request()->evaluation_status, [
                            "class" => "form-control select2 " ,
                            "id" => "evaluation_status",
                            "placeholder" => trans('main.evaluation_status')
                        ])}}

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


    <div class="wrapper wrapper-content animated fadeInRight">
        @if($rows->count()>0)


            <div class="row">
                @foreach($rows as $row)
                    <div class="col-lg-6">
                        <div class="contact-box">
                            <a href="{{url('admin/applicant-worker/'.$row->id)}}">
                                <div class="col-sm-4">
                                    <div class="text-center">
                                        {{--                                        <img alt="image" class="img-circle m-t-xs img-responsive" src="{{url('assets/admin/img/a2.jpg')}}">--}}
                                        <img alt="image" class="img-circle m-t-xs img-responsive"
                                             src="{{url($row->image_thumb ?? 'assets/admin/img/broken.png')}}">
                                        <div class="m-t-xs font-bold">{{$row->job->name ?? ''}}</div>
                                        <div class="m-t-xs font-bold"> <span class="label label-primary">{{$row->evaluation_status_display ?? ''}}</span></div>

                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <h3><strong>{{$row->name}}</strong></h3>
                                    <p><i class="fa fa-briefcase"></i> {{$row->organization->name ?? ''}}</p>
                                    <address>
                                        <strong> <i class="fa fa-building-o"></i> {{$row->project->name ?? ''}}
                                        </strong><br>
                                        <i class="fa fa-map-marker"></i> {{$row->address}}<br>
                                        <i class="fa fa-envelope-o"></i> {{$row->email}}<br>
                                        {{--San Francisco, CA 94107<br>--}}
                                        <abbr title="Phone">P:</abbr> {{$row->mobile}}

                                    </address>
                                </div>
                                <div class="clearfix"></div>
                            </a>
                        </div>
                    </div>
                @endforeach

            </div>
            <div class="text-center">
                {!! $rows->appends(request()->except('page'))->links() !!}
            </div>
        @else
            <h2 class="text-center">{{trans('main.no_records') }}</h2>
        @endif
    </div>
@stop