<!DOCTYPE html>
<html>

<head>

    {{--  Google console own  --}}
    <meta name="google-site-verification" content="oc3eQLys-WV1UDr8RfXC8MxspKuIH2d9jPqVjYL4Nx4" />

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title> {{$website_name}} | @yield('title') </title>
    <link href="{{asset('assets/admin/css/statistics.css')}}" rel="stylesheet">

    <link href="{{asset('assets/admin/css/bootstrap.min.css')}}" rel="stylesheet">
    {{--    <link href="{{asset('assets/admin/css/bootstrap-rtl.min.css')}}" rel="stylesheet">--}}
    <link href="{{asset('assets/admin/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    {{--<link href="{{asset('assets/admin/fontawesome-5.14.0/css/fontawesome.css')}}" rel="stylesheet">--}}
    {{--<link href="{{asset('assets/admin/fontawesome-5.14.0/css/brands.css')}}" rel="stylesheet">--}}
    {{--<link href="{{asset('assets/admin/fontawesome-5.14.0/css/solid.css')}}" rel="stylesheet">--}}


    <link href="{{asset('assets/admin/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/plugins/select2/select2.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/plugins/alertifyjs/css/alertify.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/plugins/alertifyjs/css/themes/default.rtl.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/plugins/toastr/toastr.min.css')}}" rel="stylesheet">
    <!-- FooTable -->
    <link href="{{asset('assets/admin/plugins/footable/footable.core.css')}}" rel="stylesheet">
    {{--    <link rel="stylesheet" href="{{asset('assets/admin/plugins/lobibox/dist/css/lobibox.css')}}">--}}
    <link rel="stylesheet"
          href="{{asset('assets/admin/plugins/jquery-ui-1.12.1/jquery-ui.min.css')}}">

    <link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="{{asset('assets/admin/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/css/tlg.css')}}" rel="stylesheet">
    {{--    <link href="{{asset('assets/admin/css/custom.css')}}" rel="stylesheet">--}}

    <style>
        .loader-container {
            position: fixed;
            left: 0;
            right: 0;
            height: 100%;
            background: #3f51b5;
            z-index: 10000;
            text-align: center;
        }

        .loader-content {
            position: relative;
            top: 40%;
        }

        .loader-text {
            display: block;
            position: relative;
            text-align: center;
            margin-top: 1em;
            font-size: 4em;
            font-weight: bolder;
            /*font-family: sans-serif;*/
            color: #fff;
            /*text-shadow: 0.063em 0.063em #004a54;*/
            -webkit-animation: bounce 3s linear infinite;
            animation: bounce 3s linear infinite;
            letter-spacing: 0.3em;
        }

        .lds-roller {
            display: inline-block;
            position: relative;
            width: 80px;
            height: 80px;
        }

        .lds-roller div {
            animation: lds-roller 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
            transform-origin: 40px 40px;
        }

        .lds-roller div:after {
            content: " ";
            display: block;
            position: absolute;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #fff;
            margin: -4px 0 0 -4px;
        }

        .lds-roller div:nth-child(1) {
            animation-delay: -0.036s;
        }

        .lds-roller div:nth-child(1):after {
            top: 63px;
            left: 63px;
        }

        .lds-roller div:nth-child(2) {
            animation-delay: -0.072s;
        }

        .lds-roller div:nth-child(2):after {
            top: 68px;
            left: 56px;
        }

        .lds-roller div:nth-child(3) {
            animation-delay: -0.108s;
        }

        .lds-roller div:nth-child(3):after {
            top: 71px;
            left: 48px;
        }

        .lds-roller div:nth-child(4) {
            animation-delay: -0.144s;
        }

        .lds-roller div:nth-child(4):after {
            top: 72px;
            left: 40px;
        }

        .lds-roller div:nth-child(5) {
            animation-delay: -0.18s;
        }

        .lds-roller div:nth-child(5):after {
            top: 71px;
            left: 32px;
        }

        .lds-roller div:nth-child(6) {
            animation-delay: -0.216s;
        }

        .lds-roller div:nth-child(6):after {
            top: 68px;
            left: 24px;
        }

        .lds-roller div:nth-child(7) {
            animation-delay: -0.252s;
        }

        .lds-roller div:nth-child(7):after {
            top: 63px;
            left: 17px;
        }

        .lds-roller div:nth-child(8) {
            animation-delay: -0.288s;
        }

        .lds-roller div:nth-child(8):after {
            top: 56px;
            left: 12px;
        }

        @keyframes lds-roller {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }


    </style>


    <style>
        div.dt-buttons {
            float: right;
            margin-bottom: 10px;
        }

        @media (max-width: 600px) {
            .hide-for-mobile {
                display: none
            }
        }
    </style>

    @stack('style')
</head>

<body>
<div class="loader-container" id="loader-container">
    <div class="loader-content">
        <div class="lds-roller">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
        <span class="loader-text">{{$website_name}}</span>
        {{--<div class="text-center">--}}
        {{--<img src="{{asset($website_image)}}" style="" height="100" width="200" alt="logo">--}}
        {{--</div>--}}
    </div>
</div>

{{--<div style="display: none" class="" id="hideAll">--}}
{{--</div>--}}

<div id="wrapper">
