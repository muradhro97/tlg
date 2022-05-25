<!DOCTYPE html>
<html>

<head>

    {{--  Google console own  --}}
    <meta name="google-site-verification" content="oc3eQLys-WV1UDr8RfXC8MxspKuIH2d9jPqVjYL4Nx4" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title> {{$website_name}} | {{trans('main.login')}}  </title>

    <link href="{{asset('assets/admin/css/bootstrap.min.css')}}" rel="stylesheet">
    {{--<link href="{{asset('assets/admin/css/bootstrap-rtl.min.css')}}" rel="stylesheet">--}}

    <link href="{{asset('assets/admin/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/plugins/toastr/toastr.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/css/animate.css')}}" rel="stylesheet">

    <link href="{{asset('assets/admin/css/style.css')}}" rel="stylesheet">

    @toastr_css
    <style>
        .system-name {
            /*color: #e6e6e6;*/
            /*font-size: 180px !important;*/
            /*font-weight: 800;*/
            /*letter-spacing: -10px;*/
            /*margin-bottom: 0;*/

            color: #e6e6e6;
            font-size: 60px !important;
            font-weight: 800;
            /*letter-spacing: -10px;*/
            margin-bottom: 50px;
            box-sizing: border-box;
        }

        .login-text {
            /*color: #e6e6e6;*/
            font-weight: 800;
        }
    </style>
</head>

<body class="gray-bg">

@inject('setting','App\Setting')
<?php
$settings = $setting->findOrNew(1);
        ?>
<div class="middle-box text-center loginscreen animated fadeInDown">

    {{--<div>--}}
    <div>
        <div>

            <h1 class="system-name">{{$website_name}}</h1>

        </div>
{{--        <h3>{{trans('main.login')}}</h3>--}}

        <div class="text-center">
            <img src="{{asset($settings->image)}}" style="margin-bottom: 15px;" height="100" width="200" alt="logo">

        </div>

        {{--<p>تسجيل الدخول</p>--}}
        <form class="m-t" role="form" action="{{ route('login') }}" method="post">

            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('main.user_name') ? ' has-error' : '' }}">
                <input type="text" class="form-control" placeholder="{{trans('main.user_name')}}" required=""
                       name="user_name">
                @if ($errors->has('user_name'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('user_name') }}</strong>
                                    </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <input type="password" class="form-control" placeholder="{{trans('main.password')}}" required=""
                       name="password">
                @if ($errors->has('password'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                @endif
            </div>


            <button type="submit" class="btn btn-primary block full-width m-b">{{trans('main.login')}}</button>
            {{--<a href="{{url('reset-password-view')}}" class="btn btn-success block full-width m-b">استرجاع كلمة المرور</a>--}}
            {{--<a href="{{route('admin.forgetPassword')}}"><small>نسيت كلمة المرور ؟</small></a>--}}
            {{--<a href="#">--}}
            {{--<small>Forgot password?</small>--}}
            {{--</a>--}}
            {{--<p class="text-muted text-center">--}}
            {{--<small>Do not have an account?</small>--}}
            {{--</p>--}}
            {{--<a class="btn btn-sm btn-white btn-block" href="register.html">Create an account</a>--}}
        </form>
        <p class="m-t">

            <small> Copyright  {{$website_name}} &copy; {{date('Y')}}</small>
            <br>
            Developed by <strong> <a href="http://hatem-goda.com">Hatem Goda</a> </strong>

        </p>
    </div>
</div>

<!-- Mainly scripts -->
<script src="{{asset('assets/admin/js/jquery-2.1.1.js')}}"></script>
<script src="{{asset('assets/admin/js/bootstrap.min.js')}}"></script>

<!-- Custom and plugin javascript -->
<script src="{{asset('assets/admin/js/inspinia.js')}}"></script>
<script src="{{asset('assets/admin/plugins/toastr/toastr.min.js')}}"></script>
@toastr_render
</body>

</html>
