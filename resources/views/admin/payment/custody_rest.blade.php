@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.custody'),'url'=>'/'])
@stop
@section('content')
    <!-- FILE: app/views/start.blade.php -->
    <div class="ibox ">
        <div class="ibox-title">
            <h5>{{trans('main.custody')}} | {{trans('main.new')}} </h5>
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


        <div class="ibox-content">
            <div class="row">
                <div class="col-lg-5">
                    <dl class="dl-horizontal">


                        <dt>{{trans('main.transaction_no')}}:</dt>
                        <dd> {{$model->id}}      </dd>
                        <dt>{{trans('main.organization')}}:</dt>
                        <dd> {{$model->organization->name ?? ''}}      </dd>


                    </dl>
                </div>
                <div class="col-lg-7" id="cluster_info">
                    <dl class="dl-horizontal">

                        <dt>{{trans('main.amount')}}:</dt>
                        <dd> {{$model->amount}}      </dd>
                        <dt>{{trans('main.project')}}:</dt>
                        <dd> {{$model->project->name ?? ''}}</dd>


                    </dl>
                </div>
            </div>
        </div>
        {!! Form::model($model,[
                     'action'=>'Admin\PaymentController@storeCustodyRest',
                     'id'=>'myForm',
                     'role'=>'form',
                       'files'=>'true',
                     'method'=>'POST'
                     ])!!}
        <div class="ibox-content">
            @include('admin.payment.custody_rest_form')
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