@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.activity_logs'),'url'=>'activity-log'])
@stop
@section('content')

@inject('user','App\User')



<?php


$users = $user->latest()->pluck('name', 'id')->toArray();

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
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="description">{{trans('main.description') }}</label>
                        <input type="text" id="description" name="description" value="{{request()->description}}"
                               placeholder="{{trans('main.description') }}"
                               class="form-control">
                    </div>
                </div>
                {{--<div class="col-sm-4">--}}
                    {{--<div class="form-group">--}}
                        {{--<label class="control-label" for="description">{{trans('main.description') }}</label>--}}
                        {{--<input type="text" id="description" name="description" value="{{request()->description}}"--}}
                               {{--placeholder="{{trans('main.description') }}"--}}
                               {{--class="form-control">--}}
                    {{--</div>--}}
                {{--</div>--}}
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="user_id">{{trans('main.user')}}</label>
                        {{Form::select('user_id', $users, request()->user_id, [
                            "class" => "form-control select2 " ,
                            "id" => "user_id",
                            "placeholder" => trans('main.user')
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
    <div class="ibox ibox-primary">
        <div class="ibox-title">
            <h5>{{trans('main.activity_logs') }}</h5>
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
            @can('addCountry')
                <div class="">
                    <a href="{{url('admin/country/create')}}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> {{trans('main.new') }}
                    </a>
                </div>
            @endcan
            <div class="clearfix"></div>
            <br>


            @if($rows->count()>0)
                <div class="table-responsive">
                    <table class="data-table table table-bordered">
                        <thead>
                        <th>#</th>
                        {{--<th>{{trans('main.name') }}</th>--}}
                        {{--<th>{{trans('main.nationality') }}</th>--}}
{{--                        <th >{{trans('main.module') }}</th>--}}
                        <th >{{trans('main.description') }}</th>
                        <th >{{trans('main.user_name') }}</th>
                        <th >{{trans('main.date') }}</th>
                        <th >{{trans('main.full_date') }}</th>

                        </thead>
                        <tbody>
                        @php $count = 1; @endphp
                        @foreach($rows as $row)
                            <?php
                            $iteration = $loop->iteration + (($rows->currentPage() - 1) * $rows->perPage())
                            ?>
                            <tr>
                                <td>{{$iteration}}</td>
{{--                                <td>{{$row->subject->name ??''}}</td>--}}



                                <td>{{$row->description}}</td>
{{--                                <td>{{explode('\\', $row->subject_type)[1] .' ' .$row->description}}</td>--}}
                                <td>{{$row->causer->name ?? 'deleted user'}}</td>
                                <td>{{$row->created_at->diffForHumans()}}</td>
                                <td >{{$row->created_at->toDayDateTimeString() }} </td>

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
@stop