@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.employees'),'url'=>'employee'])
@stop
@section('content')
    @inject('organization','App\Organization')
    @inject('project','App\Project')
    @inject('job','App\Job')

    @inject('department','App\Department')



    <?php


    $organizations = $organization->latest()->pluck('name', 'id')->toArray();


    $projects = $project->latest()->whereIn('id', auth()->user()->projects->pluck('id')->toArray())->pluck('name', 'id')->toArray();


    $jobs = $job->latest()->where('type', 'employee')->pluck('name', 'id')->toArray();


    $departments = $department->latest()->pluck('name', 'id')->toArray();




    $socialStatusOptions = [


        'single' => trans('main.single'),
        'married' => trans('main.married'),
        'divorced' => trans('main.divorced'),
        'widowed' => trans('main.widowed'),

    ];
    $militaryOptions = [
        'exemption' => trans('main.exemption'),
        'done' => trans('main.done'),
        'delayed' => trans('main.delayed'),

    ];
    $workingStatusOptions = [


        'work' => trans('main.work'),
        'fired' => trans('main.fired'),
        'resigned' => trans('main.resigned'),
        'retired' => trans('main.retired'),
        'not_started' => trans('main.not_started'),

    ];
    ?>
    <div>
        @can('addEmp')
            <a href="{{url('admin/employee/create')}}" class="btn btn-primary">
                <i class="fa fa-plus"></i> {{trans('main.new_employee') }}
            </a>
        @endcan
        <a href="{{route('employees.export',$request->all())}}" class="btn btn-primary">
            <i class="fa fa-file-excel-o"></i>
            {{trans('main.excel')}}
        </a>
    </div>
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
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="name">{{trans('main.name') }}</label>
                        <input type="text" id="name" name="name" value="{{request()->name}}"
                               placeholder="{{trans('main.name') }}"
                               class="form-control">
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
                        {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="project_id">{{trans('main.project')}}</label>
                        {{Form::select('project_id', $projects, request()->project_id, [
                            "class" => "form-control select2 " ,
                            "id" => "project_id",
                            "placeholder" => trans('main.project')
                        ])}}
                        {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
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
                        {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="department_id">{{trans('main.department')}}</label>
                        {{Form::select('department_id', $departments, request()->department_id, [
                            "class" => "form-control select2 " ,
                            "id" => "department_id",
                            "placeholder" => trans('main.department')
                        ])}}
                        {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="working_status">{{trans('main.working_status')}}</label>
                        {{Form::select('working_status', $workingStatusOptions, request()->working_status, [
                            "class" => "form-control select2 " ,
                            "id" => "working_status",
                            "placeholder" => trans('main.working_status')
                        ])}}
                        {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="social_status">{{trans('main.social_status')}}</label>
                        {{Form::select('social_status', $socialStatusOptions, request()->social_status, [
                            "class" => "form-control select2 " ,
                            "id" => "social_status",
                            "placeholder" => trans('main.social_status')
                        ])}}
                        {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="military_status">{{trans('main.military_status')}}</label>
                        {{Form::select('military_status', $militaryOptions, request()->military_status, [
                            "class" => "form-control select2 " ,
                            "id" => "military_status",
                            "placeholder" => trans('main.military_status')
                        ])}}
                        {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
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
                        <div class="contact-box" style="height: 240px;">
                            <div class="row">
                                <div class="col-md-8">
                                    <a href="{{url('admin/employee/'.$row->id)}}">
                                        <div class="col-sm-4">
                                            <div class="text-center">
                                                {{--                                        <img alt="image" class="img-circle m-t-xs img-responsive" src="{{url('assets/admin/img/a2.jpg')}}">--}}
                                                <img alt="image" class="img-circle m-t-xs img-responsive"
                                                     src="{{url($row->image_thumb ?? 'assets/admin/img/broken.png')}}">
                                                <div class="m-t-xs font-bold">{{$row->job->name ?? '...'}}</div>
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <h3><strong>{{$row->name}}</strong></h3>
                                            <p><i class="fa fa-briefcase"></i> {{$row->organization->name ?? '...'}}</p>
                                            <address>
                                                <strong> <i class="fa fa-building-o"></i> {{$row->project->name ?? '...'}}
                                                </strong><br>
                                                <i class="fa fa-map-marker"></i> {{$row->address}}<br>
                                                <i class="fa fa fa-id-badge"></i> {{$row->unique_no}}<br>
                                                <i class="fa fa-envelope-o"></i> {{$row->email}}<br>
                                                <i class="fa fa-user"></i> {{$row->WorkingStatusDisplay}}<br>

                                                {{--San Francisco, CA 94107<br>--}}
                                                <abbr title="Phone">P:</abbr> {{$row->mobile}}

                                            </address>
                                        </div>
                                        <div class="clearfix"></div>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a class="btn btn-outline btn-warning pull-right" target="_blank" href="{{url('admin/employee-print/'.$row->id)}}"><i
                                            class="fa fa-print"></i> {{trans('main.print_id_card')}}
                                    </a>
                                    @can('editEmp')
                                        <a href="{{url('admin/employee/'.$row->id.'/edit')}}"
                                           class="btn btn-outline btn-primary  pull-right m-t-sm">{{trans('main.edit')}}</a>
                                    @endcan
                                    @can('deleteEmp')
                                        {{Form::open(array('method'=>'delete','class'=>'delete','url'=>route('employee.destroy', $row->id) )) }}
                                        <button type="submit" class="destroy btn btn-outline btn-danger pull-right m-sm"><i
                                                class="fa fa-trash-o"></i></button>
                                        {{Form::close()}}
                                        {{--                                        <form action="{{route('worker.destroy', $row->id)}}" method="delete">--}}
                                        {{--                                            <button type="submit" class="btn btn-outline btn-danger pull-right m-t-sm">{{trans('main.delete')}}</button>--}}
                                        {{--                                        </form>--}}
                                    @endcan
                                </div>
                            </div>


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
