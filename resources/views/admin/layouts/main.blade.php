@include('admin.layouts.includes.head')
@include('admin.layouts.includes.sidebar')

<div id="page-wrapper" class="gray-bg">
@include('admin.layouts.includes.header')


   @yield('breadcrumb')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center m-t-lg"> </div>
                    @yield('content')
                    {{--<h1>--}}
                        {{--Welcome in INSPINIA Static SeedProject--}}
                    {{--</h1>--}}
                    {{--<small>--}}
                        {{--It is an application skeleton for a typical web app. You can use it to quickly bootstrap--}}
                        {{--your webapp projects and dev environment for these projects.--}}
                    {{--</small>--}}

            </div>
        </div>
    </div>


@include('admin.layouts.includes.footer')
</div>


@include('admin.layouts.includes.foot')


