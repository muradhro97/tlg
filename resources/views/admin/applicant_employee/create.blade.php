@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.applicant_employees'),'url'=>'applicant-employee'])
@stop
@section('content')
        <!-- FILE: app/views/start.blade.php -->
<div class="ibox ">
    <div class="ibox-title">
        <h5>{{trans('main.applicant_employees')}} |  {{trans('main.new')}} </h5>
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
                            'action'=>'Admin\ApplicantEmployeeController@store',
                            'id'=>'myForm',
                            'role'=>'form',
                            'files'=>'true',
                            'method'=>'POST'
                            ])!!}
    <div class="ibox-content">
        @include('admin.applicant_employee.form')
        @include('admin.applicant_employee.script')
    </div>
    <div class="ibox-footer">


        <div class="row pull-right">
            <button type="submit" class="btn btn-primary disableOnSubmit">{{trans('main.save')}}</button>
            <button type="reset" class="btn btn-danger">{{trans('main.cancel')}}</button>
        </div>
    </div>
    {!! Form::close()!!}
</div>
@stop