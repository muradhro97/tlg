@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.workers'),'url'=>'worker'])
@stop
@section('content')
    <!-- FILE: app/views/start.blade.php -->
    <div class="ibox ">
        <div class="ibox-title">
            <h5>{{trans('main.workers')}} | {{trans('main.worker_import')}} </h5>
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
                                'action'=>'Admin\WorkerController@importSave',
                                'id'=>'myForm',
                                'role'=>'form',
                                'files'=>'true',
                                'method'=>'POST'
                                ])!!}
        <div class="ibox-content">

            <div class="form-group">
                <label>{{trans('main.upload_excel_file')}}</label>
                <div class="">
                    <input name="file" type="file" id="file" class="form-control"   >
                </div>


            </div>
            <div class="form-group">
                <label>{{trans('main.excel_sample')}}</label>
                <div class="">
                    <a class="btn btn-success" target="_blank" href="{{url('worker_excel_sample.xlsx')}}"><i
                                class="fa fa-file-o"></i> {{trans('main.download')}}</a>
                </div>


            </div>


        </div>
        <div class="ibox-footer">


            <div class="row">
                <div class="row  text-center">
                    <button type="submit" class="btn btn-primary disableOnSubmit">{{trans('main.save')}}</button>
                    <button type="reset" class="btn btn-danger">{{trans('main.cancel')}}</button>
                </div>
            </div>
        </div>
        {!! Form::close()!!}

    </div>
@stop