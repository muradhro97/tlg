@extends('admin.layouts.main')
@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.employee_monthly_evaluations'),'url'=>'employee-monthly-evaluation'])
@stop
@section('content')
        <!-- FILE: app/views/start.blade.php -->
<div class="ibox">
    <div class="ibox-title">
        <h5>{{trans('main.employee_monthly_evaluations')}} |  {{trans('main.edit')}} </h5>
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
                            'action'=>['Admin\EmployeeMonthlyEvaluationController@update',$model->id],
                            'id'=>'myForm',
                            'role'=>'form',
                             'files'=>'true',
                            'method'=>'PUT'
                            ])!!}
    <div class="ibox-content">
        @include('admin.employee_monthly_evaluation.form_edit')
    </div>
    <div class="ibox-footer">
        <div class="row">
            <div class="col-sm-6 col-sm-push-2">
                <button type="submit" class="btn btn-primary disableOnSubmit">{{trans('main.save')}}</button>
            </div>
            <div class="col-sm-6">
                <button type="reset" class="btn btn-danger">{{trans('main.cancel')}}</button>
            </div>
        </div>
    </div>
    {!! Form::close()!!}
</div>
@stop