@extends('admin.layouts.main')
@section('title')
    {{trans('main.dashboard')}}
@stop
@section('content')


    @inject('safe','App\Safe')
    @inject('safeTransaction','App\SafeTransaction')
    @inject('accounting','App\Accounting')
    @inject('workerTimeSheet','App\WorkerTimeSheet')
    @inject('employeeTimeSheet','App\EmployeeTimeSheet')
    @inject('extract','App\Extract')

    <?php

    $extracts = $extract->count();
    $main_safe = $safe->find(0);
    $bank_safe = $safe->where('id', '!=', 0)->get();
    $today_worker_loans = $accounting->where('type', 'workerLoan')
        ->where('payment_status', 'confirmed')
        ->where('date', today())->sum('amount');

    $monthly_worker_loans = $accounting->where('type', 'workerLoan')
        ->where('payment_status', 'confirmed')
        ->whereMonth('date',now())->whereYear('date', now())->sum('amount');

    $today_employee_loans = $accounting->where('type', 'employeeLoan')
        ->where('payment_status', 'confirmed')
        ->where('date', today())->sum('amount');

    $monthly_employee_loans = $accounting->where('type', 'employeeLoan')
        ->where('payment_status', 'confirmed')
        ->whereMonth('date',now())->whereYear('date', now())->sum('amount');








    $today_worker_salary = $accounting->where('type', 'workerSalary')
        ->where('payment_status', 'confirmed')
        ->where('date', today())->sum('amount');

    $last_month_worker_salary = $accounting->where('type', 'workerSalary')
        ->where('payment_status', 'confirmed')
        ->whereMonth('date',now()->subMonth())->whereYear('date', now()->subMonth())->sum('amount');

    $today_employee_salary = $accounting->where('type', 'employeeSalary')
        ->where('payment_status', 'confirmed')
        ->where('date', today())->sum('amount');

    $last_month_employee_salary = $accounting->where('type', 'employeeSalary')
        ->where('payment_status', 'confirmed')
        ->whereMonth('date',now()->subMonth())->whereYear('date', now()->subMonth())->sum('amount');


    $wor_sheets= $workerTimeSheet->where('date', today())->get();
    $emp_sheets= $employeeTimeSheet->where('date', today())->get();
    ?>

    {{--<div class="row">--}}
    {{--<div class="col-md-12">--}}
    <h1 class="animate-typing text-center" data-animate-loop="true" data-type-delay="300" data-cursor-speed="700"
        data-animate-index="0">TONG LONG GROUP Dashboard</h1>
    {{--<h1 class=" text-center">{{trans('main.dashboard')}}</h1>--}}
    {{--<p>--}}
    {{--@if(app()->getLocale()=="en")--}}
    {{--Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the--}}
    {{--industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type--}}
    {{--and scrambled it to make a type specimen book. It has survived not only five centuries, but also the--}}
    {{--leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s--}}
    {{--with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop--}}
    {{--publishing software like Aldus PageMaker including versions of Lorem Ipsum.--}}
    {{--@elseif(app()->getLocale()=="ch")--}}
    {{--也称乱数假文或者哑元文本， 是印刷及排版领域所常用的虚拟文字。由于曾经一台匿名的打印机刻意打乱了一盒印刷字体从而造出一本字体样品书，Lorem--}}
    {{--Ipsum从西元15世纪起就被作为此领域的标准文本使用。它不仅延续了五个世纪，还通过了电子排版的挑战，其雏形却依然保存至今。在1960年代，”Leatraset”公司发布了印刷着Lorem--}}
    {{--Ipsum段落的纸张，从而广泛普及了它的使用。最近，计算机桌面出版软件”Aldus PageMaker”也通过同样的方式使Lorem Ipsum落入大众的视野。--}}
    {{--@endif--}}

    {{--</p>--}}

    {{--</div>--}}
    {{--</div>--}}

    {{--<div class="row">--}}

    {{--<div class="col-lg-6">--}}
    {{--<div class="widget  mb-none yellow-bg p-lg text-center" data-toggle="collapse"--}}
    {{--href="#collapseWorkerByProject"--}}
    {{--aria-expanded="false" aria-controls="collapseMedia">--}}
    {{--<div class="m-b-md">--}}
    {{--<i class="fa fa-building-o fa-4x"></i>--}}
    {{--<h1 class="m-xs">{{$worker_by_projects->sum('total')}}</h1>--}}
    {{--<h4 class=" font-bold no-margins">--}}
    {{--{{trans('main.worker_by_project')}}--}}
    {{--</h4>--}}
    {{--<small>We detect the error.</small>--}}
    {{--</div>--}}
    {{--</div>--}}

    {{--<div class="collapse" id="collapseWorkerByProject">--}}
    {{--<div class="well">--}}
    {{--<table class="table">--}}
    {{--<tbody>--}}
    {{--@foreach( $worker_by_projects  as $bp)--}}
    {{--<tr>--}}
    {{--<td>--}}
    {{--<button type="button" class="btn btn-danger m-r-sm">  {{$bp->name}}</button>--}}
    {{--{{$bp->total}}--}}
    {{--</td>--}}

    {{--</tr>--}}

    {{--@endforeach--}}
    {{--</tbody>--}}
    {{--</table>--}}


    {{--</div>--}}
    {{--</div>--}}

    {{--</div>--}}
    {{--<div class="col-lg-6">--}}
    {{--<div class="widget  mb-none red-bg p-lg text-center" data-toggle="collapse" href="#collapseWorkerByJob"--}}
    {{--aria-expanded="false" aria-controls="collapseMedia">--}}
    {{--<div class="m-b-md">--}}
    {{--<i class="fa fa-calendar-check-o fa-4x"></i>--}}
    {{--<h1 class="m-xs">{{$worker_by_jobs->sum('total')}}</h1>--}}
    {{--<h4 class="font-bold  no-margins">--}}
    {{--{{trans('main.worker_by_job')}}--}}
    {{--</h4>--}}
    {{--<small>We detect the error.</small>--}}
    {{--</div>--}}
    {{--</div>--}}

    {{--<div class="collapse" id="collapseWorkerByJob">--}}
    {{--<div class="well">--}}
    {{--<table class="table">--}}
    {{--<tbody>--}}
    {{--@foreach( $worker_by_jobs  as $bj)--}}
    {{--<tr>--}}
    {{--<td>--}}
    {{--<button type="button" class="btn btn-danger m-r-sm">  {{$bj->name}}</button>--}}
    {{--{{$bj->total}}--}}
    {{--</td>--}}

    {{--</tr>--}}

    {{--@endforeach--}}
    {{--</tbody>--}}
    {{--</table>--}}


    {{--</div>--}}
    {{--</div>--}}

    {{--</div>--}}
    {{--</div>--}}









    <div class="row">

        <div class="col-lg-3">
            <div class="widget  mb-none yellow-bg p-lg text-center" data-toggle="collapse"
                 href="#collapseWorkerByProject"
                 aria-expanded="false" aria-controls="collapseMedia">
                <div class="m-b-md">
                    <i class="fa fa-calendar-check-o fa-4x"></i>
                    <h1 class="m-xs">{{$worker_by_projects->sum('total')}}</h1>
                    <h4 class=" font-bold no-margins">
                        {{trans('main.worker_by_project')}}
                    </h4>
                    {{--<small>We detect the error.</small>--}}
                </div>
            </div>

            <div class="collapse" id="collapseWorkerByProject">
                <div class="well">
                    <table class="table">
                        <tbody>
                        @foreach( $worker_by_projects  as $bp)
                            <tr>
                                <td>
                                    <button type="button" class="btn btn-danger m-r-sm">  {{$bp->name}}</button>
                                    {{$bp->total}}
                                </td>

                            </tr>

                        @endforeach
                        </tbody>
                    </table>


                </div>
            </div>

        </div>
        <div class="col-lg-3">
            <div class="widget  mb-none red-bg p-lg text-center" data-toggle="collapse" href="#collapseWorkerByJob"
                 aria-expanded="false" aria-controls="collapseMedia">
                <div class="m-b-md">
                    <i class="fa fa-calendar-check-o fa-4x"></i>
                    <h1 class="m-xs">{{$worker_by_jobs->sum('total')}}</h1>
                    <h4 class="font-bold  no-margins">
                        {{trans('main.worker_by_job')}}
                    </h4>
                    {{--<small>We detect the error.</small>--}}
                </div>
            </div>

            <div class="collapse" id="collapseWorkerByJob">
                <div class="well">
                    <table class="table">
                        <tbody>
                        @foreach( $worker_by_jobs  as $bj)
                            <tr>
                                <td>
                                    <button type="button" class="btn btn-danger m-r-sm">  {{$bj->name}}</button>
                                    {{$bj->total}}
                                </td>

                            </tr>

                        @endforeach


                        </tbody>
                    </table>


                </div>
            </div>

        </div>


        <div class="col-lg-3">
            <div class="widget  mb-none yellow-bg p-lg text-center" data-toggle="collapse"
                 href="#collapseTodayWorkerByProject"
                 aria-expanded="false" aria-controls="collapseMedia">
                <div class="m-b-md">
                    <i class="fa fa-calendar-check-o fa-4x"></i>
                    <h1 class="m-xs">{{$today_worker_by_projects->sum('total')}}</h1>
                    <h4 class=" font-bold no-margins">
                        {{trans('main.today_worker_by_project')}}
                    </h4>
                    {{--<small>We detect the error.</small>--}}
                </div>
            </div>

            <div class="collapse" id="collapseTodayWorkerByProject">
                <div class="well">
                    <table class="table">
                        <tbody>
                        @foreach( $today_worker_by_projects  as $bp)
                            <tr>
                                <td>
                                    <button type="button" class="btn btn-danger m-r-sm">  {{$bp->name}}</button>
                                    {{$bp->total}}
                                </td>

                            </tr>

                        @endforeach
                        </tbody>
                    </table>


                </div>
            </div>

        </div>
        <div class="col-lg-3">
            <div class="widget  mb-none navy-bg p-lg text-center" data-toggle="collapse" href="#collapseTodayWorkerByJob"
                 aria-expanded="false" aria-controls="collapseMedia">
                <div class="m-b-md">
                    <i class="fa fa-calendar-check-o fa-4x"></i>
                    <h1 class="m-xs">{{$today_worker_by_jobs->sum('total')}}</h1>
                    <h4 class="font-bold  no-margins">
                        {{trans('main.today_worker_by_job')}}
                    </h4>
                    {{--<small>We detect the error.</small>--}}
                </div>
            </div>

            <div class="collapse" id="collapseTodayWorkerByJob">
                <div class="well">
                    <table class="table">
                        <tbody>
                        @foreach( $today_worker_by_jobs  as $bj)
                            <tr>
                                <td>
                                    <button type="button" class="btn btn-danger m-r-sm">  {{$bj->name}}</button>
                                    {{$bj->total}}
                                </td>

                            </tr>

                        @endforeach


                        </tbody>
                    </table>


                </div>
            </div>

        </div>
        <div class="clearfix"></div>
        <div class="col-lg-6">
            <div class="widget  mb-none yellow-bg p-lg text-center" data-toggle="collapse"
                 href="#collapseEmployeeByProject"
                 aria-expanded="false" aria-controls="collapseMedia">
                <div class="m-b-md">
                    <i class="fa fa-calendar-check-o fa-4x"></i>
                    <h1 class="m-xs">{{$employee_by_projects->sum('total')}}</h1>
                    <h4 class=" font-bold no-margins">
                        {{trans('main.employee_by_project')}}
                    </h4>
                    {{--<small>We detect the error.</small>--}}
                </div>
            </div>

            <div class="collapse" id="collapseEmployeeByProject">
                <div class="well">
                    <table class="table">
                        <tbody>
                        @foreach( $employee_by_projects  as $bp)
                            <tr>
                                <td>
                                    <button type="button" class="btn btn-danger m-r-sm">  {{$bp->name}}</button>
                                    {{$bp->total}}
                                </td>

                            </tr>

                        @endforeach
                        </tbody>
                    </table>


                </div>
            </div>

        </div>
        <div class="col-lg-6">
            <div class="widget  mb-none red-bg p-lg text-center" data-toggle="collapse" href="#collapseEmployeeByJob"
                 aria-expanded="false" aria-controls="collapseMedia">
                <div class="m-b-md">
                    <i class="fa fa-calendar-check-o fa-4x"></i>
                    <h1 class="m-xs">{{$employee_by_jobs->sum('total')}}</h1>
                    <h4 class="font-bold  no-margins">
                        {{trans('main.employee_by_job')}}
                    </h4>
                    {{--<small>We detect the error.</small>--}}
                </div>
            </div>

            <div class="collapse" id="collapseEmployeeByJob">
                <div class="well">
                    <table class="table">
                        <tbody>
                        @foreach( $employee_by_jobs  as $bj)
                            <tr>
                                <td>
                                    <button type="button" class="btn btn-danger m-r-sm">  {{$bj->name}}</button>
                                    {{$bj->total}}
                                </td>

                            </tr>

                        @endforeach


                        </tbody>
                    </table>


                </div>
            </div>

        </div>
        <div class="clearfix"></div>
        <div class="col-lg-4">
            <div class="widget red-bg p-lg text-center">
                <div class="m-b-md">
                    <i class="fa fa-calendar-check-o fa-4x"></i>
                    <h1 class="m-xs">{{$contracts}}</h1>
                    <h4 class=" no-margins">
                        {{trans('main.contracts')}}
                    </h4>
                    {{--<small>We detect the error.</small>--}}
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="widget navy-bg p-lg text-center">
                <div class="m-b-md">
                    <i class="fa fa-calendar-check-o fa-4x"></i>
                    <h1 class="m-xs">{{$sub_contracts}}</h1>
                    <h4 class=" no-margins">
                        {{trans('main.sub_contracts')}}
                    </h4>
                    {{--<small>We detect the error.</small>--}}
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="widget red-bg p-lg text-center">
                <div class="m-b-md">
                    <i class="fa fa-calendar-check-o fa-4x"></i>
                    <h1 class="m-xs">{{$extracts}}</h1>
                    <h4 class=" no-margins">
                        {{trans('main.extracts')}}
                    </h4>
                    {{--<small>We detect the error.</small>--}}
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-lg-6">
            <div class="widget navy-bg p-lg text-center">
                <div class="m-b-md">
                    <i class="fa fa-calendar-check-o fa-4x"></i>
                    <h1 class="m-xs">{{$main_safe->balance}}</h1>
                    <h4 class=" no-margins">
                        {{trans('main.safe_balance')}}
                    </h4>
                    {{--<small>We detect the error.</small>--}}
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="widget  mb-none red-bg p-lg text-center" data-toggle="collapse" href="#collapseBankBalance"
                 aria-expanded="false" aria-controls="collapseMedia">
                <div class="m-b-md">
                    <i class="fa fa-calendar-check-o fa-4x"></i>
                    <h1 class="m-xs">{{$bank_safe->sum('balance')}}</h1>
                    <h4 class="font-bold  no-margins">
                        {{trans('main.bank_balance')}}
                    </h4>
                    {{--<small>We detect the error.</small>--}}
                </div>
            </div>

            <div class="collapse" id="collapseBankBalance">
                <div class="well">
                    <table class="table">
                        <tbody>
                        @foreach( $bank_safe  as $bj)
                            <tr>
                                <td>
                                    <button type="button" class="btn btn-danger m-r-sm">  {{$bj->name}}</button>
                                    {{$bj->balance}}
                                </td>

                            </tr>

                        @endforeach


                        </tbody>
                    </table>


                </div>
            </div>

        </div>
        <div class="clearfix"></div>

        <div class="col-lg-3">
            <div class="widget red-bg p-lg text-center">
                <div class="m-b-md">
                    <i class="fa fa-calendar-check-o fa-4x"></i>
                    <h1 class="m-xs">{{$today_worker_loans}}</h1>
                    <h4 class=" no-margins">
                        {{trans('main.today_worker_loans')}}
                    </h4>
                    {{--<small>We detect the error.</small>--}}
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="widget navy-bg p-lg text-center">
                <div class="m-b-md">
                    <i class="fa fa-calendar-check-o fa-4x"></i>
                    <h1 class="m-xs">{{$monthly_worker_loans}}</h1>
                    <h4 class=" no-margins">
                        {{trans('main.monthly_worker_loans')}}
                    </h4>
                    {{--<small>We detect the error.</small>--}}
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="widget yellow-bg p-lg text-center">
                <div class="m-b-md">
                    <i class="fa fa-calendar-check-o fa-4x"></i>
                    <h1 class="m-xs">{{$today_employee_loans}}</h1>
                    <h4 class=" no-margins">
                        {{trans('main.today_employee_loans')}}
                    </h4>
                    {{--<small>We detect the error.</small>--}}
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="widget red-bg p-lg text-center">
                <div class="m-b-md">
                    <i class="fa fa-calendar-check-o fa-4x"></i>
                    <h1 class="m-xs">{{$monthly_employee_loans}}</h1>
                    <h4 class=" no-margins">
                        {{trans('main.monthly_employee_loans')}}
                    </h4>
                    {{--<small>We detect the error.</small>--}}
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="col-lg-3">
            <div class="widget red-bg p-lg text-center">
                <div class="m-b-md">
                    <i class="fa fa-calendar-check-o fa-4x"></i>
                    <h1 class="m-xs">{{$today_worker_salary}}</h1>
                    <h4 class=" no-margins">
                        {{trans('main.today_worker_salary')}}
                    </h4>
                    {{--<small>We detect the error.</small>--}}
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="widget yellow-bg p-lg text-center">
                <div class="m-b-md">
                    <i class="fa fa-calendar-check-o fa-4x"></i>
                    <h1 class="m-xs">{{$last_month_worker_salary}}</h1>
                    <h4 class=" no-margins">
                        {{trans('main.last_month_worker_salary')}}
                    </h4>
                    {{--<small>We detect the error.</small>--}}
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="widget red-bg p-lg text-center">
                <div class="m-b-md">
                    <i class="fa fa-calendar-check-o fa-4x"></i>
                    <h1 class="m-xs">{{$today_employee_salary}}</h1>
                    <h4 class=" no-margins">
                        {{trans('main.today_employee_salary')}}
                    </h4>
                    {{--<small>We detect the error.</small>--}}
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="widget lazur-bg p-lg text-center">
                <div class="m-b-md">
                    <i class="fa fa-calendar-check-o fa-4x"></i>
                    <h1 class="m-xs">{{$last_month_employee_salary}}</h1>
                    <h4 class=" no-margins">
                        {{trans('main.last_month_employee_salary')}}
                    </h4>
                    {{--<small>We detect the error.</small>--}}
                </div>
            </div>
        </div>




        <div class="col-lg-6">
            <div class="widget  mb-none yellow-bg p-lg text-center" data-toggle="collapse"
                 href="#collapseEmpSheets"
                 aria-expanded="false" aria-controls="collapseMedia">
                <div class="m-b-md">
                    <i class="fa fa-calendar-check-o fa-4x"></i>
                    <h1 class="m-xs">  {{$wor_sheets->count()}}</h1>
                    <h4 class=" font-bold no-margins">
                        {{trans('main.worker_time_sheet_today')}}
                    </h4>
                    {{--<small>We detect the error.</small>--}}
                </div>
            </div>

            <div class="collapse" id="collapseEmpSheets">
                <div class="well">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>
                                <button type="button" class="btn btn-danger m-r-sm">  {{trans('main.days')}}</button>
                                {{$wor_sheets->count()}}
                            </td>

                        </tr>

                        <tr>
                            <td>
                                <button type="button" class="btn btn-danger m-r-sm">   {{trans('main.overtime')}}</button>
                                {{$wor_sheets->sum('overtime')}}
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <button type="button" class="btn btn-danger m-r-sm">   {{trans('main.deduction_hrs')}}</button>
                                {{$wor_sheets->sum('deduction_hrs')}}
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <button type="button" class="btn btn-danger m-r-sm">   {{trans('main.deduction_value')}}</button>
                                {{$wor_sheets->sum('deduction_value')}}
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <button type="button" class="btn btn-danger m-r-sm">   {{trans('main.safety')}}</button>
                                {{$wor_sheets->sum('safety')}}
                            </td>

                        </tr>

                        </tbody>
                    </table>


                </div>
            </div>

        </div>
        <div class="col-lg-6">
            <div class="widget red-bg p-lg text-center">
                <div class="m-b-md">
                    <i class="fa fa-calendar-check-o fa-4x"></i>
                    <h1 class="m-xs"> {{$emp_sheets->count()}}</h1>
                    <h4 class=" no-margins">
                        {{trans('main.employee_time_sheet_today')}}
                    </h4>
                    {{--<small>We detect the error.</small>--}}
                </div>
            </div>

        </div>
    </div>

    @push('script')
        <script src="{{asset('assets/admin/plugins/animate-typing/jquery.animateTyping.js')}}"></script>
    @endpush
@stop


