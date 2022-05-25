@extends('admin.layouts.main')
@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.worker_time_sheet'),'url'=>'worker-time-sheet'])
@stop
@section('content')
    <!-- FILE: app/views/start.blade.php -->
    <div class="ibox">
        <div class="ibox-title">
            <h5>{{trans('main.worker_time_sheet')}} |  {{trans('main.edit')}} </h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
                <a class="close-link">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
        <!-- form start -->
        {!! Form::model($model,[
                                'action'=>['Admin\WorkerTimeSheetController@update',$model->id],
                                'id'=>'myForm',
                                'role'=>'form',
                                'method'=>'PUT'
                                ])!!}
        <div class="ibox-content">
            @include('admin.worker_time_sheet.form_edit')
        </div>
        <div class="ibox-footer">
            <div class="row  text-center">
                <button type="submit" class="btn btn-primary disableOnSubmit">{{trans('main.save')}}</button>
                <button type="reset" class="btn btn-danger">{{trans('main.cancel')}}</button>
            </div>
        </div>
        {!! Form::close()!!}
    </div>

@stop