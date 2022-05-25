@include('partials.validation-errors')

@inject('organization','App\Organization')
@inject('project','App\Project')
@inject('employee','App\Employee')
<?php


$organizations = $organization->latest()->pluck('name', 'id')->toArray();


$projects = $project->latest()->pluck('name', 'id')->toArray();
$employees = $employee->latest()->pluck('name', 'id')->toArray();
?>

<div class="row">
    <div class="col-md-6">

        {!! Field::date('date' , trans('main.date') ) !!}
    </div>
    <div class="col-md-6">
        {!! Field::floatOnly('amount' , trans('main.amount') ) !!}

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

        {!! Field::select('employee_id' , trans('main.employee'),$employees,trans('main.select_employee')) !!}
    </div>


</div>


<div class="row">
    <div class="col-md-6">


        {!! Field::textarea('details' , trans('main.details') ) !!}
    </div>
    <div class="col-md-6">


        {!! Field::textarea('description' , trans('main.description') ) !!}
    </div>

</div>


@include('partials.images_uploader')
