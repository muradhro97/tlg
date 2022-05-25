<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>شركه {{$website_name}} | نسيت كلمة المرور</title>

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
        <h3 class="login-text" >نسيت كلمة المرور</h3>
<p>برجاء ادخل رقم التليفون لارسال كود التحقق</p>
        <div class="text-center">
            {{--<img src="{{asset('assets/admin/project-image/logo.png')}}" style="margin-bottom: 15px;" height="200" width="300" alt="logo">--}}

        </div>

        {{--<p>تسجيل الدخول</p>--}}
        <form class="m-t" role="form" action="{{ route('admin.forgetPasswordDo') }}" method="post">

            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                <input type="text" class="form-control" placeholder="رقم التيلفون" required="" name="phone">
                @if ($errors->has('phone'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                @endif

            </div>



            <button type="submit" class="btn btn-primary block full-width m-b">ارسال كود التحقق </button>
            {{--<a href="{{url('reset-password-view')}}" class="btn btn-success block full-width m-b">استرجاع كلمة المرور</a>--}}
            <a class="btn btn-sm btn-white btn-block" href="{{route('admin.login')}}">تسجيل الدخول</a>
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