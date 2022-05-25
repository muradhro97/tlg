<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title> {{$website_name}} | Dashboard </title>

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

    <link href="{{asset('assets/admin/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/css/tlg.css')}}" rel="stylesheet">
{{--    <link href="{{asset('assets/admin/css/custom.css')}}" rel="stylesheet">--}}

<style>
    /*#hideAll*/
    /*{*/
        /*position: fixed;*/
        /*left: 0px;*/
        /*right: 0px;*/
        /*top: 0px;*/
        /*bottom: 0px;*/
        /*background-color: white;*/
        /*z-index: 99; !* Higher than anything else in the document *!*/

    /*}*/
/*loader */
    .loader-container {
        position: fixed;
        left: 0;
        right: 0;
        height: 100%;
        background: #1ab394;
        z-index: 10000;
        text-align: center;
    }
    .loader-content {
        position: relative;
        top: 40%;
    }
    .loader {
        border: 0.250em solid #1ab394;
        border-radius: 50%;
        border-top: 0.250em solid #caf9ff;
        border-bottom: 0.250em solid #caf9ff;
        width: 3em;
        height: 3em;
        -webkit-animation: spin 1s ease-out infinite;
        animation: spin 1s ease-out infinite;
        display: inline-block;
        background: #17ecc1;
        -webkit-box-shadow: 0em 0em 0.813em 0.25em #8adbff;
        box-shadow: 0em 0em 0.813em 0.25em #8adbff;
        zoom: 1;
    }
    .loader-text {
        display: block;
        position: relative;
        text-align: center;
        margin-top: 0.5em;
        font-size: 2em;
        font-family: sans-serif;
        color: #fff;
        text-shadow: 0.063em 0.063em #004a54;
        -webkit-animation: bounce 3s linear infinite;
        animation: bounce 3s linear infinite;
        letter-spacing: 0.3em;
    }

    @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); transform: rotate(360deg); }
    }

    @keyframes spin {
        0% { -webkit-transform: rotate(0deg); transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); transform: rotate(360deg); }
    }

    @-webkit-keyframes bounce {
        0% {
            top: 0;
        }
        25% {
            top: 0.625em;
        }
        50% {
            top: 0;
        }
        75% {
            top: 0.625em;
        }
        100% {
            top: 0;
        }
    }

    @keyframes bounce {
        0% {
            top: 0;
        }
        25% {
            top: 0.625em;
        }
        50% {
            top: 0;
        }
        75% {
            top: 0.625em;
        }
        100% {
            top: 0;
        }
    }



</style>
    @stack('style')
</head>

<body >
<div class="loader-container" id="loader-container">
    <div class="loader-content">
        <span class="loader"></span>
        <span class="loader-text">{{$website_name}}</span>
    </div>
</div>

{{--<div style="display: none" class="" id="hideAll">--}}
{{--</div>--}}

<div id="wrapper">
