<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    {{--<title>خطاب قبول</title>--}}

    <style>
        .invoice-box {
            /*max-width: 800px;*/
            margin: auto;
            padding: 30px;
            /*border: 1px solid #eee;*/
            /*box-shadow: 0 0 10px rgba(0, 0, 0, .15);*/
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            /*text-align: right;*/
        }

        .text-center {
            text-align: center;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
        thead td{
            border: 1px solid #e7e7e7;
            border-collapse: collapse;
            font-weight: bold;
        }
        .big-table , .big-table td {
            border: 1px solid #e7e7e7;
            border-collapse: collapse;
        }
        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .rtl table {
            text-align: right;
        }

        .rtl table tr td:nth-child(2) {
            text-align: left;
        }
    </style>
</head>

<body>
<div class="invoice-box ">

    <?php
    $projects = [];
    foreach ($row->accountingEmployeeSalaryDetail as $r)
    {
        $projects[]= $r->employee->project->name;
    }
    $projects = array_unique($projects);
    ?>


    <table cellpadding="0" cellspacing="0">


        <tr class="top">
            <td>
                <table>
                    <tr>
                        <td >
                            <h1>{{trans('main.worker_salary')}}</h1>
                        </td>
                        <td class="title">
                            <img src="{{url($main_settings->image)}}" style="width: 80%; height: 80px; max-width: 300px"/>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="information">
            <td >
                <table>
                    <tr>
                        <td>
                            {{trans('main.safe') }}
                        </td>

                        <td>
                            {{$row->safe->name ?? ''}}
                        </td>
                        <td>
                            {{trans('main.amount') }}
                        </td>

                        <td>
                            {{$row->amount}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{trans('main.date') }}
                        </td>

                        <td>{{$row->date}}</td>
                        {{--<td>--}}
                            {{--{{trans('main.to') }}--}}
                        {{--</td>--}}

                        {{--<td>--}}
                            {{--{{$row->end}}--}}
                        {{--</td>--}}
                    </tr>
                    <tr>
                        <td>
                            {{trans('main.projects') }}
                        </td>

                        <td>
                            @foreach($projects as $p)
                                {{$p}} <br>
                            @endforeach
                        </td>
                        {{--                        <td>--}}
                        {{--                            {{trans('main.to') }}--}}
                        {{--                        </td>--}}

                        {{--                        <td>--}}
                        {{--                            {{$row->end}}--}}
                        {{--                        </td>--}}
                    </tr>
                </table>
            </td>
        </tr>

        {{--<tr class="heading">--}}
        {{--<td>--}}
        {{--Payment Method--}}
        {{--</td>--}}

        {{--<td>--}}
        {{--Check #--}}
        {{--</td>--}}
        {{--</tr>--}}

        {{--<tr class="details">--}}
        {{--<td>--}}
        {{--Check--}}
        {{--</td>--}}

        {{--<td>--}}
        {{--1000--}}
        {{--</td>--}}
        {{--</tr>--}}



        {{--<tr class="item last">--}}
        {{--<td>--}}
        {{--Domain name (1 year)--}}
        {{--</td>--}}

        {{--<td>--}}
        {{--$10.00--}}
        {{--</td>--}}
        {{--</tr>--}}


    </table>
    <div class="row">

        @if($row->accountingEmployeeSalaryDetail()->count()>0)
            <div class="table-responsive">
                <table class="data-table table table-bordered big-table">
                    <thead>
                    <tr>
                        {{--<th colspan="10"></th>--}}
                        <td rowspan="2">#</td>

                        {{--                        <td>{{trans('main.transaction_no') }}</td>--}}
                        <td rowspan="2">{{trans('main.id') }}</td>
                        <td rowspan="2">{{trans('main.name') }}</td>
                        <td rowspan="2">{{trans('main.job') }}</td>
                        <td rowspan="2">{{trans('main.days') }}</td>
                        <td rowspan="2">{{trans('main.current_salary_per_hours') }}</td>
                        <td rowspan="2">{{trans('main.total_regular_hours') }}</td>
                        <td rowspan="2">{{trans('main.total_regular') }}</td>
                        <td rowspan="2">{{trans('main.total_overtime_hours') }}</td>
                        <td rowspan="2">{{trans('main.total_overtime') }}</td>
                        <td rowspan="2">{{trans('main.total_salary_hours') }}</td>
                        <td rowspan="2">{{trans('main.total_salary') }}</td>
                        <td colspan="3" rowspan="1"
                            class="text-center">{{trans('main.allowances')}}</td>
                        <td colspan="3" rowspan="1"
                            class="text-center">{{trans('main.deductions')}}</td>

                        <td rowspan="2">{{trans('main.monthly_evaluations') }}</td>
                        <td rowspan="2">{{trans('main.loans') }}</td>
                        <td rowspan="2">{{trans('main.net') }}</td>
                        <td rowspan="2">{{trans('main.signature') }}</td>
                        {{--                            <th colspan="3">{{trans('main.deductions')}}</th>--}}
                        {{--<th colspan="1"></th>--}}
                    </tr>
                    <tr>


                        {{--<th rowspan="1" colspan="3">{{trans('main.aa') }}</th>--}}
                        <td rowspan="1">{{trans('main.meals') }}</td>
                        <td rowspan="1">{{trans('main.communications') }}</td>
                        <td rowspan="1">{{trans('main.transports') }}</td>
                        <td>{{trans('main.penalties') }}</td>
                        <td>{{trans('main.taxes') }}</td>
                        <td>{{trans('main.insurance') }}</td>

                    </tr>

                    </thead>
                    <tbody>

                    @foreach($row->accountingEmployeeSalaryDetail as $r)

                        <tr>
                            <td>{{ $loop->iteration}}</td>
                            {{--                                <td>{{$row->id}}</td>--}}
                            <td>{{$r->employee->id}}</td>
                            <td>{{$r->employee->name}}</td>
                            <td>{{$r->employee->job->name ?? ''}}</td>
                            <td>{{$r->days}}</td>
                            <td>{{$r->hourly_salary}} </td>
                            <td>{{$r->total_regular_minutes/60}}</td>
                            <td>{{$r->total_regular}}</td>
                            <td>{{$r->overtime_minutes/60}}</td>
                            <td>{{$r->overtime}} </td>
                            <td>{{$r->total_daily_minutes/60}}</td>
                            <td>{{$r->total_daily}}</td>
                            <td>{{$r->meals}}</td>
                            <td>{{$r->communications}}</td>
                            <td>{{$r->transports}}</td>
                            <td>{{$r->penalties}}</td>


                            <td>{{$r->taxes}}</td>
                            <td>{{$r->insurance}}</td>
                            <td>{{$r->monthly_evaluations}}</td>
                            <td>{{$r->loans}}</td>

                            <td>{{$r->net}}</td>
                            <td></td>

                            {{--<td class="text-center"><a href="{{url('admin/stock-transaction/'.$row->id.'/edit')}}"--}}
                            {{--class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a>--}}
                            {{--</td>--}}
                            {{--<td class="text-center">--}}
                            {{--{{Form::open(array('method'=>'delete','class'=>'delete','url'=>url('admin/stock-transaction/'.$row->id) )) }}--}}
                            {{--<button type="submit" class="destroy btn btn-danger btn-xs"><i--}}
                            {{--class="fa fa-trash-o"></i></button>--}}
                            {{--{{Form::close()}}--}}
                            {{--</td>--}}
                        </tr>

                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td>{{trans('main.total')}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{$row->accountingEmployeeSalaryDetail()->sum('days')}}</td>
                        <td>{{number_format($row->accountingEmployeeSalaryDetail()->sum('hourly_salary'),2)}}</td>
                        <td>{{$row->accountingEmployeeSalaryDetail()->sum('total_regular_minutes')/60}}</td>
                        <td>{{number_format($row->accountingEmployeeSalaryDetail()->sum('total_regular'),2)}}</td>
                        <td>{{$row->accountingEmployeeSalaryDetail()->sum('overtime_minutes')/60}}</td>
                        <td>{{number_format($row->accountingEmployeeSalaryDetail()->sum('overtime'),2)}}</td>
                        <td>{{$row->accountingEmployeeSalaryDetail()->sum('total_daily_minutes')/60}}</td>
                        <td>{{number_format($row->accountingEmployeeSalaryDetail()->sum('total_daily'),2)}}</td>
                        <td>{{number_format($row->accountingEmployeeSalaryDetail()->sum('rewards'),2)}}</td>
                        <td>{{number_format($row->accountingEmployeeSalaryDetail()->sum('meals'),2)}}</td>
                        <td>{{number_format($row->accountingEmployeeSalaryDetail()->sum('communications'),2)}}</td>
                        <td>{{number_format($row->accountingEmployeeSalaryDetail()->sum('transports'),2)}}</td>
                        <td>{{number_format($row->accountingEmployeeSalaryDetail()->sum('penalties'),2)}}</td>
                        <td>{{number_format($row->accountingEmployeeSalaryDetail()->sum('taxes'),2)}}</td>
                        <td>{{number_format($row->accountingEmployeeSalaryDetail()->sum('insurance'),2)}}</td>
                        <td>{{number_format($row->accountingEmployeeSalaryDetail()->sum('monthly_evaluations'),2)}}</td>
                        {{--                                    <td>{{number_format($row->accountingEmployeeSalaryDetail()->sum('loans'),2)}}</td>--}}
                        <td>{{number_format($row->accountingEmployeeSalaryDetail()->sum('net') + $row->accountingEmployeeSalaryDetail()->sum('loans'),2)}}</td>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <div class="text-center">
                {{--{!! $rows->appends(request()->except('page'))->links() !!}--}}
            </div>
        @else
            <h2 class="text-center">{{trans('main.no_records') }}</h2>
        @endif
    </div>
</div>
<script>
//    window.print();
//    var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
//    if (isChrome == false) window.close();
</script>
</body>
</html>
