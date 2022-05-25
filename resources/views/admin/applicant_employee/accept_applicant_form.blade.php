@include('partials.validation-errors')

@include('flash::message')


<h2  class="font-bold  red-bg"  style=" padding: 10px;">{{trans('main.job_data')}}</h2>
<hr>


<div class="row">
    <div class="col-md-6">
        {!! Field::date('start_date' , trans('main.start_date') ) !!}
    </div>
    <div class="col-md-6">
        {!! Field::text('location' , trans('main.location') ) !!}

    </div>

</div>

<div class="row">
    <div class="col-md-6">
        {!! Field::text('test_period' , trans('main.test_period') ) !!}
    </div>
    <div class="col-md-6">
        {!! Field::text('basic_salary' , trans('main.basic_salary') ) !!}

    </div>

</div>

<div class="row">
    <div class="col-md-6">
        {!! Field::text('test_salary' , trans('main.test_salary') ) !!}
    </div>
    <div class="col-md-6">
        {!! Field::text('allowances' , trans('main.allowances') ) !!}

    </div>

</div>

<div class="row">
    <div class="col-md-6">
        {!! Field::textarea('job_description' , trans('main.job_description') ) !!}
    </div>
    <div class="col-md-6">
        {!! Field::textarea('papers_needed' , trans('main.papers_needed') ) !!}

    </div>

</div>
