@include('partials.validation-errors')

@inject('organization','App\Organization')
@inject('project','App\Project')
@inject('job','App\Job')
@inject('university','App\University')
@inject('department','App\Department')
@inject('country','App\Country')
@inject('bank','App\Bank')
@inject('department','App\Department')
{{--@inject('job','App\Department')--}}


<?php


$organizations = $organization->latest()->pluck('name', 'id')->toArray();

$banks = $bank->latest()->pluck('name', 'id')->toArray();
$projects = $project->latest()->pluck('name', 'id')->toArray();
$jobs = $job->latest()->where('type', 'employee')->pluck('name', 'id')->toArray();

$universities = $university->latest()->pluck('name', 'id')->toArray();
$nationalities = $country->latest()->pluck('nationality', 'id')->toArray();
$departments = $department->latest()->pluck('name', 'id')->toArray();
//$departments = $department->latest()->pluck('name', 'id')->toArray();


$genderOptions = [


    'male' => trans('main.male'),
    'female' => trans('main.female'),

];

$socialStatusOptions = [


    'single' => trans('main.single'),
    'married' => trans('main.married'),
    'divorced' => trans('main.divorced'),
    'widowed' => trans('main.widowed'),

];
$militaryOptions = [
    'exemption' => trans('main.exemption'),
    'done' => trans('main.done'),
    'delayed' => trans('main.delayed'),

];
$workingStatusOptions = [


    'work' => trans('main.work'),
    'fired' => trans('main.fired'),
    'resigned' => trans('main.resigned'),
//    'retired' => trans('main.retired'),

];

?>
@include('flash::message')

<input type="hidden" name="experiences">
<input type="hidden" name="educations">
<h2  class="font-bold  red-bg"  style=" padding: 10px;">{{trans('main.personal_date')}}</h2>
<hr>
<div class="row">
    <div class="col-md-2">
        <div class="row text-center">

            {!! Field::image('image' , trans('main.image'),'/'.$model->image) !!}
        </div>

    </div>
    <div class="col-md-10">

        <div class="row">
            <div class="col-md-6">
                {!! Field::text('name' , trans('main.name') ) !!}
            </div>
            <div class="col-md-6">
                {!! Field::select('job_id' , trans('main.job'),$jobs,trans('main.select_job')) !!}

            </div>

        </div>

        <div class="row">

            <div class="col-md-6">
                {!! Field::select('nationality_id' , trans('main.nationality'),$nationalities, trans('main.select_nationality')) !!}
            </div>
            <div class="col-md-6">
                {!! Field::select('social_status' , trans('main.social_status'),$socialStatusOptions, trans('main.social_status')) !!}

            </div>

        </div>
        <div class="row">
            <div class="col-md-6">
                {!! Field::text('nationality_no' , trans('main.nationality_no') ) !!}
            </div>
            <div class="col-md-6">
                {!! Field::select('military_status' , trans('main.military_status'),$militaryOptions,trans('main.military_status')) !!}


            </div>

        </div>
        <div class="row">
            <div class="col-md-6">
                {!! Field::select('gender' , trans('main.gender'),$genderOptions, trans('main.gender')) !!}
            </div>
            <div class="col-md-6">
                {!! Field::text('address' , trans('main.address') ) !!}

            </div>

        </div>
        <div class="row">

            <div class="col-md-6">
                {!! Field::birthDate('birth_date' , trans('main.birth_date') ) !!}

            </div>
            <div class="col-md-6">
                {!! Field::text('current_address' , trans('main.current_address') ) !!}
            </div>

        </div>

        <div class="row">

            <div class="col-md-6">
                {!! Field::text('mobile' , trans('main.mobile') ) !!}

            </div>
            <div class="col-md-6">
                {!! Field::text('email' , trans('main.email') ) !!}

            </div>
        </div>
    </div>
</div>




<hr>
<h2  class="font-bold  red-bg"  style=" padding: 10px;" >{{trans('main.education_date')}}</h2>
<hr>
<div class=" row">
    <div class="col-xs-4" style="padding-right: 5px;">

        {{Form::text('qualification_title', null, [   "placeholder" => trans('main.qualification_title'),"class" => "form-control ",   ])}}

    </div>
    <div class="col-xs-3" style="padding-right: 5px;">

        {{--<input type="text" class="form-control">--}}
        {{Form::text('university', null, [   "placeholder" => trans('main.university'),"class" => "form-control ",   ])}}

    </div>
    <div class="col-xs-3" style="padding-right: 5px;">
        {{Form::text('graduation_year', null, [  "placeholder" =>trans('main.graduation_year'), "class" => "form-control ", ])}}

    </div>
    <div class="col-xs-2" style="padding-right: 5px;">

    </div>
    <div class="col-xs-2" style="padding-right: 5px;">
        <button type="button" class="btn btn-success" id="add-education">{{trans('main.add')}}</button>
    </div>

</div>
<hr>
<div class="table-responsive">
    <table class="data-table table table-bordered">
        <thead>
        <th>#</th>
        <th>{{trans('main.qualification_title')}}</th>
        <th>{{trans('main.university')}}</th>
        <th>{{trans('main.graduation_year')}}</th>


        <th class="text-center">Delete</th>
        </thead>
        <tbody class="educations-append-area">

        <tr>

        </tr>



        </tbody>
    </table>
</div>
<hr>



<h2   class="font-bold  red-bg"  style=" padding: 10px;">{{trans('main.experience_date')}}</h2>
<hr>
<div class=" row">
    <div class="col-xs-2" style="padding-right: 5px;">

        {{Form::text('employer_name', null, [   "placeholder" => trans('main.employer_name'),"class" => "form-control",   ])}}

    </div>
    <div class="col-xs-2" style="padding-right: 5px;">

        {{--<input type="text" class="form-control">--}}
        {{Form::text('from', null, [   "placeholder" => trans('main.from'),"class" => "form-control datepicker"  ])}}

    </div>
    <div class="col-xs-2" style="padding-right: 5px;">
        {{Form::text('to', null, [  "placeholder" =>trans('main.to'), "class" => "form-control datepicker"])}}

    </div>

    <div class="col-xs-2" style="padding-right: 5px;">

        {{Form::text('position', null, [   "placeholder" => trans('main.position'),"class" => "form-control ",   ])}}

    </div>
    <div class="col-xs-2" style="padding-right: 5px;">

        {{Form::text('working_status', null, [   "placeholder" => trans('main.working_status'),"class" => "form-control ",   ])}}

    </div>
    <div class="col-xs-2" style="padding-right: 5px;">

    </div>
    <div class="col-xs-2" style="padding-right: 5px;">
        <button type="button" class="btn btn-success" id="add-experience">{{trans('main.add')}}</button>
    </div>

</div>
<hr>
<div class="table-responsive">
    <table class="data-table table table-bordered">
        <thead>
        <th>#</th>
        <th>{{trans('main.employer_name')}}</th>
        <th>{{trans('main.from')}}</th>
        <th>{{trans('main.to')}}</th>
        <th>{{trans('main.position')}}</th>
        <th>{{trans('main.working_status')}}</th>


        <th class="text-center">Delete</th>
        </thead>
        <tbody class="experiences-append-area">

        <tr>

        </tr>



        </tbody>
    </table>
</div>


<div class="row">
    <div class="col-md-6">


        {!! Field::textarea('courses' , trans('main.courses') ) !!}
    </div>
    <div class="col-md-6">
        {!! Field::textarea('skills' , trans('main.skills') ) !!}


    </div>

</div>
<hr>

<h2  class="font-bold  red-bg"  style=" padding: 10px;">{{trans('main.employer_date')}}</h2>

<hr>



<div class="row">
    <div class="col-md-6">

        {{--        {!! Field::select('department_id' , trans('main.department'),$departments,trans('main.department')) !!}--}}

        {!! Field::floatOnly('last_salary' , trans('main.last_salary') ) !!}
    </div>
    <div class="col-md-6">
        {!! Field::text('expected_salary' , trans('main.expected_salary') ) !!}

    </div>

</div>



<div class="row">
    <div class="col-md-6">


        {!! Field::textarea('abilities' , trans('main.abilities') ) !!}
    </div>
    <div class="col-md-6">
        {!! Field::textarea('overview' , trans('main.overview') ) !!}


    </div>

</div>
<div class="row">
    <div class="col-md-6">


        {!! Field::textarea('reasons' , trans('main.reasons') ) !!}
    </div>
    <div class="col-md-6">
        {!! Field::textarea('notes' , trans('main.notes') ) !!}

    </div>

</div>



{{--{!! Field::textarea('expected_salary' , trans('main.expected_salary') ) !!}--}}









<div class="input-field">
    <label class="active">{{trans('main.documents')}}</label>
    <div class="input-images-1" style="padding-top: .5rem;"></div>
</div>


{{--<div class="upload-btn-wrapper">--}}
{{--<label onclick="preview_image();" class="btn-add-image"><i class="fa fa-upload  btn btn-outline-light"></i></label>--}}
{{--<input type="file" id="upload_file" name="upload_file[]" style="display: none;" onchange="preview_image();" multiple/>--}}
{{--</div>--}}

{{--<div id="image_preview"></div>--}}
{{--{!! Field::fileWithPreview('images[]' , trans('main.documents_image'),true) !!}--}}
{{--<div class="col-md-6">--}}
{{--<div class="fileinput fileinput-new input-group" data-provides="fileinput">--}}
{{--<div class="form-control" data-trigger="fileinput">--}}
{{--<i class="glyphicon glyphicon-file fileinput-exists"></i>--}}
{{--<span class="fileinput-filename"></span>--}}
{{--</div>--}}
{{--<span class="input-group-addon btn btn-default btn-file">--}}
{{--<span class="fileinput-new">Select file</span>--}}
{{--<span class="fileinput-exists">Change</span>--}}
{{--<input type="file" name="..." multiple/>--}}
{{--</span>--}}
{{--<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>--}}
{{--</div>--}}
{{--</div>--}}

@push('style')
    <link rel="stylesheet" type="text/css"
          href="{{asset('assets/admin/plugins/jasny-bootstrap/css/jasny-bootstrap.min.css')}}"/>
    {{--<link rel="stylesheet" href="{{asset('assets/admin/plugins/bootstrap-fileinput/css/fileinput.min.css')}}">--}}
    {{--<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/4.0.0/css/jasny-bootstrap.min.css">--}}
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" type="text/css"
          href="{{asset('assets/admin/plugins/jquery-image-uploader-preview-and-delete/image-uploader.min.css')}}"/>

@endpush
@push('script')

    <script type="text/javascript"
            src="{{asset('assets/admin/plugins/jasny-bootstrap/js/jasny-bootstrap.min.js')}}"></script>
    {{--<script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/4.0.0/js/jasny-bootstrap.min.js"></script>--}}
    <script type="text/javascript"
            src="{{asset('assets/admin/plugins/jquery-image-uploader-preview-and-delete/image-uploader.min.js')}}"></script>

    <script>


        $(document).ready(function()
        {
//            $('form').ajaxForm(function()
//            {
//                alert("Uploaded SuccessFully");
//            });
        });
        $('.input-images-1').imageUploader({
            label: "{{trans('main.drag_drop_files')}}",
//            imagesInputName: 'Custom Name',
        });
        //        function preview_image()
        //        {
        //            var total_file=document.getElementById("upload_file").files.length;
        //            for(var i=0;i<total_file;i++)
        //            {
        //                $('#image_preview').append("<img src='"+URL.createObjectURL(event.target.files[i])+"'>");
        //            }
        //        }
    </script>
@endpush


