@include('partials.validation-errors')

@inject('organization','App\Organization')
@inject('project','App\Project')
@inject('employee','App\Employee')
@inject('contract','App\Contract')
<?php

$typeOptions = [


    'cash' => trans('main.cash'),
    'bank' => trans('main.bank'),
    'transaction' => trans('main.transaction'),
];
$organizations = $organization->latest()->pluck('name', 'id')->toArray();


$projects = $project->latest()->pluck('name', 'id')->toArray();
$employees = $employee->latest()->pluck('name', 'id')->toArray();
$contracts = $contract->latest()->pluck('no', 'id')->toArray();
?>
{{--<iframe src ="{{ asset('test2.pdf') }}" width="100%" height="600px"></iframe>--}}
<div class="row">
    <div class="col-md-6">

        {!! Field::text('date' , trans('main.date') ) !!}
    </div>
    <div class="col-md-6">
        {!! Field::text('amount' , trans('main.amount') ) !!}

    </div>

</div>
<div class="row">
    <div class="col-md-6">

        {!! Field::select('organization_id' , trans('main.organization'),$organizations,trans('main.select_organization')) !!}
    </div>
    <div class="col-md-6">
        {!! Field::select('project_id' , trans('main.project'),$projects,trans('main.select_project')) !!}

    </div>

</div>


<div class="row">
    <div class="col-md-6">

        {!! Field::select('contract_id' , trans('main.contract'),$contracts,trans('main.select_contract')) !!}
    </div>
    <div class="col-md-6">
        {!! Field::select('extract_id' , trans('main.extract'),$projects,trans('main.select_extract')) !!}

    </div>

</div>
<div class="row">
    <div class="col-md-6">


        {!! Field::select('type' , trans('main.type'),$typeOptions,trans('main.type')) !!}

    </div>
    <div class="col-md-6">

        {!! Field::select('employee_id' , trans('main.employee'),$employees,trans('main.select_employee')) !!}
    </div>


</div>


{{--<div class="row">--}}
    {{--<div class="col-md-6">--}}


        {{--{!! Field::textarea('details' , trans('main.details') ) !!}--}}
    {{--</div>--}}
    {{--<div class="col-md-6">--}}


        {{--{!! Field::textarea('description' , trans('main.description') ) !!}--}}
    {{--</div>--}}

{{--</div>--}}


{{--@include('partials.images_uploader')--}}
