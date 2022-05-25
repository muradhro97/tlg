@include('partials.validation-errors')

@inject('project','App\Project')

<?php
$projects = $project->latest()->pluck('name', 'id')->toArray();
?>
{!! Field::text('name' , trans('main.name') ) !!}
{!! Field::text('user_name' , trans('main.user_name') ) !!}
{!! Field::text('email' , trans('main.email')) !!}

{!! Field::multiSelect('projects_list',trans('main.projects') , $projects ,trans('main.projects') ) !!}
{!! Field::password('password' , trans('main.password')) !!}
{!! Field::password('password_confirmation' , trans('main.password_confirmation')) !!}






