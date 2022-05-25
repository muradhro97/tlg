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
    foreach ($row->accountingWorkerSalaryDetail as $r)
    {
        $projects[]= $r->worker->project->name;
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
                            {{trans('main.from') }}
                        </td>

                        <td>{{$row->start}}</td>
                        <td>
                            {{trans('main.to') }}
                        </td>

                        <td>
                            {{$row->end}}
                        </td>
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

        @if($row->accountingWorkerSalaryDetail()->count()>0)
            <div class="table-responsive">
                <table class="data-table table table-bordered big-table">
                    <thead>
                    <td>#</td>
                    <td>{{trans('main.id') }}</td>
                    <td>{{trans('main.name') }}</td>
                    {{--                        <td>{{trans('main.contract_type') }}</td>--}}
                    {{--                        <td>{{trans('main.custody_transaction_no') }}</td>--}}
                    <td>{{trans('main.days') }}</td>
                    <td>{{trans('main.current_daily_salary') }}</td>
                    <td>{{trans('main.daily_salary') }}</td>
                    <td>{{trans('main.overtime') }}({{trans('main.hours')}})</td>
                    <td>{{trans('main.current_hourly_salary') }}</td>
                    <td>{{trans('main.additions') }}</td>
                    <td>{{trans('main.deduction_hrs') }}</td>
                    <td>{{trans('main.deduction_value') }}</td>
                    <td>{{trans('main.safety') }}</td>
                    <td>{{trans('main.discounts') }}</td>
                    <td>{{trans('main.total') }}</td>
                    <td>{{trans('main.loans') }}</td>
                    <td>{{trans('main.taxes') }}</td>
                    <td>{{trans('main.insurance') }}</td>
                    <td>{{trans('main.net') }}</td>
                    <td>{{trans('main.signature') }}</td>

                    </thead>
                    <tbody>

                    @foreach($row->accountingWorkerSalaryDetail as $r)

                        <tr>
                            <td>{{ $loop->iteration}}</td>
                            {{--                                <td>{{$row->id}}</td>--}}
                            <td>{{$r->worker->id}}</td>
                            <td>{{$r->worker->name}}</td>
                            <td>{{$r->days}}</td>
                            <td>{{number_format($r->worker->job->daily_salary ?? 0,2)}}</td>
                            <td>{{number_format($r->daily_salary,2)}}</td>
                            <td>{{$r->overtime}}</td>
                            <td>{{number_format($r->worker->job->hourly_salary ?? 0,2)}}</td>
                            <td>{{number_format($r->additions,2)}}</td>
                            <td>{{$r->deduction_hrs}}</td>
                            <td>{{number_format($r->deduction_value,2)}}</td>
                            <td>{{$r->safety}}</td>
                            <td>{{number_format($r->discounts,2)}}</td>
                            <td>{{number_format($r->total,2)}}</td>
                            <td>{{number_format($r->loans,2)}}</td>
                            <td>{{number_format($r->taxes,2)}}</td>
                            <td>{{number_format($r->insurance,2)}}</td>
                            <td>{{number_format($r->net,2)}}</td>
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
                        <td>TOTAL</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{number_format($row->accountingWorkerSalaryDetail->sum('daily_salary'),2)}}</td>
                        <td>{{number_format($row->accountingWorkerSalaryDetail->sum('overtime'),2)}}</td>
                        <td></td>
                        <td>{{number_format($row->accountingWorkerSalaryDetail->sum('additions'),2)}}</td>
                        <td>{{number_format($row->accountingWorkerSalaryDetail->sum('deduction_hrs'),2)}}</td>
                        <td>{{number_format($row->accountingWorkerSalaryDetail->sum('deduction_value'),2)}}</td>
                        <td>{{number_format($row->accountingWorkerSalaryDetail->sum('safety'),2)}}</td>
                        <td>{{number_format($row->accountingWorkerSalaryDetail->sum('discounts'),2)}}</td>
                        <td>{{number_format($row->accountingWorkerSalaryDetail->sum('total'),2)}}</td>
                        <td>{{number_format($row->accountingWorkerSalaryDetail->sum('loans'),2)}}</td>
                        <td>{{number_format($row->accountingWorkerSalaryDetail->sum('taxes'),2)}}</td>
                        <td>{{number_format($row->accountingWorkerSalaryDetail->sum('insurance'),2)}}</td>
                        <td>{{number_format($row->accountingWorkerSalaryDetail->sum('net'),2)}}</td>
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
    window.print();
    var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
    if (isChrome == false) window.close();
</script>
</body>
</html>
