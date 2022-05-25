@extends('admin.layouts.main')
@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.employee_time_sheet'),'url'=>'employee-time-sheet'])
@stop
@section('content')
    <!-- FILE: app/views/start.blade.php -->
    <div class="ibox">
        <div class="ibox-title">
            <h5>{{trans('main.employee_time_sheet')}} |  {{trans('main.edit')}} </h5>
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
                                'action'=>['Admin\EmployeeTimeSheetController@update',$model->id],
                                'id'=>'myForm',
                                'role'=>'form',
                                'method'=>'PUT'
                                ])!!}
        <div class="ibox-content">
            @include('admin.employee_time_sheet.form_edit')
        </div>
        <div class="ibox-footer">
            <div class="row  text-center">
                <button type="submit" class="btn btn-primary disableOnSubmit">{{trans('main.save')}}</button>
                <button type="reset" class="btn btn-danger">{{trans('main.cancel')}}</button>
            </div>
        </div>
        {!! Form::close()!!}
    </div>
    @push('style')
        <link href="{{asset('assets/admin/plugins/clockpicker/clockpicker.css')}}" rel="stylesheet">
    @endpush
    @push('script')
        <script src="{{asset('assets/admin/plugins/clockpicker/clockpicker.js')}}"></script>
        <script>
            $(function () {
                $('.clockpicker').clockpicker();

                $('#select_all').click(function () {
//                alert();
                    if ($(this).is(':checked')) {
                        $('input[type=checkbox]').prop('checked', true);
                    } else {
                        $('input[type=checkbox]').prop('checked', false);
                    }
                });
            });
            let today = new Date();


            $(".sheet_date").datepicker({
                // dateFormat: 'yy-mm-dd'
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                // setDate: currentDate,
                // regional: "ar" ,
                // yearRange: “c-70:c+10”,
//                isRTL: true,
                changeYear: true,
//                minDate: -0,
                maxDate: 0

            }).datepicker("setDate", today);
        </script>
    @endpush
@stop