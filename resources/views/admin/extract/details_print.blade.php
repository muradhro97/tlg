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



    <table cellpadding="0" cellspacing="0">

        <h1>{{trans('main.extract')}}</h1>

        <tr class="information">
            <td >
                <table>
                    <tr>
                        <td>{{trans('main.id')}}:</td>
                        <td> {{$row->id}}      </td>
                        <td>{{trans('main.date')}}:</td>
                        <td> {{$row->date}}      </td>

                    </tr>
                    <tr>
                        <td>{{trans('main.organization')}}:</td>
                        <td> {{$row->organization->name ?? ''}}      </td>
                        <td>{{trans('main.project')}}:</td>
                        <td> {{$row->project->name ?? ''}}</td>
                    </tr>

                    <tr>
                        <td>{{trans('main.sub_contract')}}:</td>
                        <td> {{$row->subContract->no ?? ''}}      </td>
                        <td>{{trans('main.contract_type')}}:</td>
                        <td> {{$row->subContract->contractType->name ?? ''}}    </td>

                    </tr>
                    <tr>

                        <td>{{trans('main.period_from')}}:</td>
                        <td> {{$row->period_from}}      </td>
                        <td>{{trans('main.period_to')}}:</td>
                        <td> {{$row->period_to}}</td>
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

        @if($row->items()->count()>0)
            <div class="row">
                <div class="table-responsive">
                    <table class="data-table table table-bordered">
                        <thead>
                        {{--<th>#</th>--}}
                        <th>{{trans('main.item_name')}}</th>
                        <th>{{trans('main.quantity')}}</th>
                        <th>{{trans('main.price')}}</th>
                        <th>{{trans('main.exchange_ratio')}}</th>
                        <th>{{trans('main.total')}}</th>


                        </thead>
                        <tbody class="">
                        <?php
                        $total_plus = 0;
                        $total_minus = 0;
                        ?>
                        @foreach($row->plus_items as  $inv)
                            <?php
                            $total_plus += $inv->price * $inv->quantity * $inv->exchange_ratio/100;
                            ?>
                            <tr style="{{$inv->item->is_minus? 'border: 2px dashed #d72323' : ''}}">

                                <td>{{$inv->item->name ?? ''}}</td>
                                <td>{{$inv->quantity?? '---'}}</td>
                                <td>{{$inv->price}}</td>
                                <td>{{$inv->exchange_ratio?? '---'}}</td>
                                @if(!$inv->item->is_minus)
                                    <td>{{ number_format($inv->price * $inv->quantity * $inv->exchange_ratio/100,4, '.', '')}}</td>
                                @else
                                    <td>{{$inv->price}}</td>
                                @endif

                            </tr>
                        @endforeach
                        <tr>

                        </tr>

                        <tr style=" border: 2px dashed #3c8dbc;">
                            <td colspan="4">{{trans('main.total')}}</td>
                            <td colspan="2" class="total">{{$total_plus}}</td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="table-responsive">
                    <table class="data-table table table-bordered">
                        <thead>
                        {{--<th>#</th>--}}
                        <th>{{trans('main.item_name')}}</th>
                        <th>{{trans('main.quantity')}}</th>
                        <th>{{trans('main.price')}}</th>
                        <th>{{trans('main.exchange_ratio')}}</th>
                        <th>{{trans('main.total')}}</th>
                        </thead>
                        <tbody class="">
                        @foreach($row->minus_items as  $inv)
                            <?php
                            $total_minus += $inv->price;
                            ?>
                            <tr style="{{$inv->item->is_minus? 'border: 2px dashed #d72323' : ''}}">

                                <td>{{$inv->item->name ?? ''}}</td>
                                <td>{{$inv->quantity?? '---'}}</td>
                                <td>{{$inv->price}}</td>
                                <td>{{$inv->exchange_ratio?? '---'}}</td>
                                @if(!$inv->item->is_minus)
                                    <td>{{ number_format($inv->price * $inv->quantity * $inv->exchange_ratio/100,4, '.', '')}}</td>
                                @else
                                    <td>{{$inv->price}}</td>
                                @endif

                            </tr>
                        @endforeach
                        <tr>

                        </tr>

                        <tr style=" border: 2px dashed #3c8dbc;">
                            <td colspan="4">{{trans('main.total')}}</td>
                            <td colspan="2" class="total">{{$total_minus}}</td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                <hr>
                <h2 class="text-center">
                    {{trans('main.net')}}:
                    {{$total_plus+$total_minus}}
                </h2>
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
