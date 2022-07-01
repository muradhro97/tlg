<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    {{--<title>خطاب قبول</title>--}}

    <style>
        .invoice-box {
            margin: auto;
            padding: 30px;
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

        <h1>{{trans('main.payments')}}</h1>

        <tr class="information">
            <td >
                <table>
                    <tr>
                        <td>{{trans('main.payment_status')}}:</td>
                        <td> {{$row->payment_status}}      </td>
                        {{-- <td>{{trans('main.date')}}:</td>
                        <td> {{$row->date}}      </td> --}}

                    </tr>
                    <tr>
                        <td>{{trans('main.date')}}:</td>
                        <td> {{$row->date}}      </td>
                        <td>{{trans('main.amount')}}:</td>
                        <td> {{$row->amount}}      </td>
                    </tr>
                    <tr>
                        <td>{{trans('main.organization')}}:</td>
                        <td> {{$row->organization->name ?? ''}}      </td>
                        
                        <td>{{trans('main.project')}}:</td>
                        <td> {{$row->project->name ?? ''}}</td>
                    </tr>

                    <tr>
                        <td>{{trans('main.submitted_by')}}:</td>
                        <td> {{$row->employee->name ?? ''}}  </td>

                        <td>{{trans('main.extract_no')}}:</td>
                        <td> {{$row->extract_no}}</td>
                    </tr>

                    <tr>
                        <td>{{trans('main.project')}}:</td>
                        <td> {{$row->project->name ?? ''}}</td>

                        <td>{{trans('main.transaction_cheque_no')}}:</td>
                        <td> {{$row->transaction_cheque_no}}</td>

                    </tr>
                    <tr>

                        <td>{{trans('main.details')}}:</dt>
                        <td> {{$row->details}}      </dd>
                        
                    </tr>


                </table>
            </td>
        </tr>


    </table>
    <div class="row">


    </div>
</div>
<script>
    window.print();
    var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
    if (isChrome == false) window.close();
</script>
</body>
</html>
