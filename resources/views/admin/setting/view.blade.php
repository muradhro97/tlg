@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.settings'),'url'=>'setting'])
@stop
@section('content')
    <!-- FILE: app/views/start.blade.php -->
    <div class="ibox ">
        <div class="ibox-title">
            <h5>{{trans('main.settings')}} | {{trans('main.edit')}}  </h5>
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
                                'action'=>'Admin\SettingController@save',
                                'id'=>'myForm',
                                'role'=>'form',
                                'files'=>'true',
                                'method'=>'Post'
                                ])!!}
        <div class="ibox-content">
            @include('admin.setting.form')
        </div>
        <div class="ibox-footer">


            <div class="row">
                <div class="col-sm-6 col-sm-push-2 col-xs-6">
                    <button type="submit" class="btn btn-primary disableOnSubmit">{{trans('main.save')}}</button>
                </div>
                <div class="col-sm-6 col-xs-6">
                    <button type="reset" class="btn btn-danger">{{trans('main.cancel')}}</button>
                </div>
            </div>
        </div>
        {!! Form::close()!!}
    </div>
@stop