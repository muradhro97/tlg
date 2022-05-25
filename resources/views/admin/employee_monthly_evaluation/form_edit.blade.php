@include('partials.validation-errors')


@inject('employee','App\Employee')


<?php

$employees = $employee->latest()->pluck('name', 'id')->toArray();
?>

<div class="form-group " id="employee_id_wrap">
    <label for="employee_id">{{trans('main.employees')}}</label>
    <div class="">
        {{ Form::select('employee_id', $employees, $model->employee_id, [
        "class" => "form-control select2 " ,
        "id" => 'employee_id',
       "disabled" => 'disabled',
        ]) }}
    </div>

</div>
{{--{!! Field::select('employee_id' , trans('main.employees'),$employees,trans('main.select_employee')) !!}--}}

<div class="form-group  @if($errors->has('date'))  has-error @endif " id="date_wrap">
    <label for="date">{{trans('main.date')}}</label>
    <div class="">
        {{ Form::text('date', null, [
         "class" => "form-control datepicker2" ,
         "id" => 'date',
         "disabled" => 'disabled',
         "placeholder" => trans('main.date'),
         ]) }}
    </div>
    @error('date')
    <span class="help-block"><strong>{{ $message }}</strong></span>
    @enderror


    <span class="help-block"><strong class=" hijri-help bg-green "></strong></span>
</div>

{!! Field::floatOnly('monthly_evaluation_percentage' , trans('main.monthly_evaluation_percentage') ) !!}


{!! Field::image('image' , trans('main.image'),'/'.$model->image) !!}

@push('style')
    <link rel="stylesheet" type="text/css"
          href="{{asset('assets/admin/plugins/jasny-bootstrap/css/jasny-bootstrap.min.css')}}"/>


@endpush
@push('script')
    <script type="text/javascript"
            src="{{asset('assets/admin/plugins/jasny-bootstrap/js/jasny-bootstrap.min.js')}}"></script>
    <script>

        $(".datepicker2").datepicker({
            currentText: "{{trans('main.current_month')}}",
            closeText: "{{trans('main.select')}}",
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            changeDay: true,
            dateFormat: 'MM yy',
//                isRTL: true,
            onClose: function (dateText, inst) {
                $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
            }

        });
    </script>
@endpush






