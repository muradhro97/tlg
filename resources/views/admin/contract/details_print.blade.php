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

        <h1>{{trans('main.contract')}}</h1>

        <tr class="information">
            <td >
                <table>
                    <tr>
                        <td>{{trans('main.id')}}:</td>
                        <td> {{$row->id}}      </td>
                        <td>{{trans('main.type')}}:</td>
                        <td> {{$row->contractType->name ?? '...'}}      </td>
                    </tr>
                    <tr>
                        <td>{{trans('main.organization')}}:</td>
                        <td> {{$row->organization->name ?? ''}}      </td>
                        <td>{{trans('main.project')}}:</td>
                        <td> {{$row->project->name ?? ''}}</td>
                    </tr>
                    <tr>

                        <td>{{trans('main.start_date')}}:</td>
                        <td> {{$row->start_date}}      </td>
                        <td>{{trans('main.finish_date')}}:</td>
                        <td> {{$row->finish_date}}</td>
                    </tr>
                    <tr>
                        <td>{{trans('main.no')}}:</td>
                        <td> {{$row->no}}      </td>
                        <td>{{trans('main.date')}}:</td>
                        <td> {{$row->date}}</td>
                    </tr>
                    <tr>
                        <td>{{trans('main.type')}}:</td>
                        <td> {{$row->type}}      </td>
                        <td>{{trans('main.status')}}:</td>
                        <td> {{$row->status}}      </td>
                    </tr>
                    <tr>
                        <td>{{trans('main.price')}}:</td>
                        <td> {{$row->price}}      </td>
                        <td>{{trans('main.duration')}}:</td>
                        <td> {{$row->duration}}      </td>

                    </tr>
                    <tr>
                        <td>{{trans('main.city')}}:</td>
                        <td> {{$row->city->name}}      </td>
                        <td>{{trans('main.details')}}:</td>
                        <td> {{$row->details}}      </td>
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
            <div class="table-responsive">
                <table class="data-table table table-bordered big-table">
                    <thead>
                    <td>{{trans('main.item_name')}}</td>
                    <td>{{trans('main.quantity')}}</td>
                    <td>{{trans('main.price')}}</td>
                    <td>{{trans('main.total')}}</td>

                    </thead>
                    <tbody>

                    @foreach($row->items as  $inv)
                        <tr>

                            <td>{{$inv->item->name ?? ''}}</td>
                            <td>{{$inv->quantity}}</td>
                            <td>{{$inv->price}}</td>
                            <td>{{ number_format($inv->price * $inv->quantity,4, '.', '')}}</td>

                        </tr>
                    @endforeach
                    <tr >
                        <td colspan="3">{{trans('main.net')}}</td>
                        <td colspan="2" class="total" style="text-align: left;">{{$row->total}}</td>
                    </tr>
                    </tbody>
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
