@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.cash_in'),'url'=>'reports/cash_in'])
@stop
@section('content')
    @inject('project','App\Project')
    @inject('organization','App\Organization')
    @inject('job','App\Job')

    @php
    $projects = $project->oldest()->pluck('name', 'id')->toArray();
    $organizations = $organization->oldest()->pluck('name', 'id')->toArray();
    $jobs = $job->oldest()->pluck('name', 'id')->toArray();
    @endphp
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
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="organization_id">{{trans('main.organization')}}</label>
                        {{Form::select('organization_id', $organizations, request()->organization_id, [
                            "class" => "form-control select2 " ,
                            "id" => "organization_id",
                            "placeholder" => trans('main.organization')
                        ])}}
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="job_id">{{trans('main.job')}}</label>
                        {{Form::select('job_id', $jobs, request()->job_id, [
                            "class" => "form-control select2 " ,
                            "id" => "job_id",
                            "placeholder" => trans('main.job')
                        ])}}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="job_id">{{trans('main.attendance')}}</label>
                        {{Form::select('attendance', [
                                'yes'=>trans('main.yes'),
                                'no'=>trans('main.no'),
                                'official_vacation_yes'=>trans('main.official_vacation_yes'),
                                'official_vacation_no'=>trans('main.official_vacation_no'),
                                'normal_vacation'=>trans('main.normal_vacation'),
                                'casual_vacation'=>trans('main.casual_vacation'),
                                ], null, [
                                "class" => "form-control select2 " ,
                                "id" => "attendance",
                                "placeholder" => trans('main.attendance')
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
            <h5>{{trans('main.Human Resources') }}</h5>
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
                        <div class="col-md-12">
{{--                            <h4>{{trans('main.funding') }}</h4>--}}

                            @if(count($rows)>0)

                            <div class="table-responsive">

                                <table class="data-table table table-bordered myTable">
                                    <thead>
                                    <th>#</th>
                                    <th>{{trans('main.project') }}</th>
                                    <th>{{trans('main.Employee Attendance Count') }}</th>
                                    <th>{{trans('main.Worker Attendance Count') }}</th>
                                    </thead>
                                    <tbody>
                                    @foreach($rows as $project)
                                        <?php
                                        $iteration = $loop->iteration
                                        ?>
                                        <tr>
                                            <td>{{$iteration}}</td>
                                            <td>{{$project->name}}</td>
                                            <td>{{$project->employees_count}}</td>
                                            <td>{{$project->worker_count}}</td>
                                            {{--                                <td>--}}
                                            {{--                                    <a href="{{route('cash_in_details',$row['id'])}}" class="btn btn-xs btn-success"><i class="fa fa-eye"></i></a>--}}
                                            {{--                                </td>--}}
                                        </tr>
                                    @endforeach
                                    </tbody>
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
                    </div>


        </div>
    </div>
@stop
