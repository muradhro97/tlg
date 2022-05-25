<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>شركه {{$website_name}} | استرجاع كلمة المرور</title>

    <link href="{{asset('assets/admin/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/css/bootstrap-rtl.min.css')}}" rel="stylesheet">

    <link href="{{asset('assets/admin/font-awesome/css/font-awesome.css')}}" rel="stylesheet">

    <link href="{{asset('assets/admin/css/animate.css')}}" rel="stylesheet">

    <link href="{{asset('assets/admin/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/css/inspina-rtl.css')}}" rel="stylesheet">
    <style>
        .system-name{
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
        .login-text{
            /*color: #e6e6e6;*/
            font-weight: 800;
        }
    </style>
</head>

<body class="gray-bg">

<div class="middle-box text-center loginscreen animated fadeInDown">

    {{--<div>--}}
    <div>
        <div>

            <h1 class="system-name">{{$website_name}}</h1>

        </div>
        <h3 class="login-text" >استرجاع كلمة المرور</h3>
        <p>برجاء ادخال كود التحقق المرسل اليك</p>
        <div class="text-center">
            {{--<img src="{{asset('assets/admin/project-image/logo.png')}}" style="margin-bottom: 15px;" height="200" width="300" alt="logo">--}}

        </div>

        {{--<p>تسجيل الدخول</p>--}}
        <form class="m-t" role="form" action="{{ route('admin.resetPasswordDo') }}" method="post">

            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('forget_code') ? ' has-error' : '' }}">
                <input type="text" class="form-control" placeholder="كود التحقق" required="" name="forget_code">
                @if ($errors->has('forget_code'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('forget_code') }}</strong>
                                    </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <input type="password" class="form-control" placeholder="كلمه المرور" required="" name="password">
                @if ($errors->has('password'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <input type="password" class="form-control" placeholder="تاكيد كلمه المرور" required="" name="password_confirmation">
                @if ($errors->has('password_confirmation'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                @endif
            </div>


            <button type="submit" class="btn btn-primary block full-width m-b">تغيير كلمة المرور</button>
            <a class="btn btn-sm btn-white btn-block" href="{{route('admin.login')}}">تسجيل الدخول</a>
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

            <small> Copyright Delivery &copy; {{date('Y')}}</small>
        </p>
    </div>
{{--</div>--}}

<!-- Mainly scripts -->
    <script src="{{asset('assets/admin/js/jquery-2.1.1.js')}}"></script>
    <script src="{{asset('assets/admin/js/bootstrap.min.js')}}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{asset('assets/admin/js/inspinia.js')}}"></script>
    <script>
        $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
    </script>
</body>

</html>