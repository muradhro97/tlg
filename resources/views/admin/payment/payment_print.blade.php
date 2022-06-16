<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>{{$website_name}}</title>

    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
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
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 5px;
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
        .invoice-box.rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .invoice-box.rtl table {
            text-align: right;
        }

        .invoice-box.rtl table tr td:nth-child(2) {
            text-align: left;
        }
    </style>
</head>

<body>
<div class="invoice-box">
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="6">
                <table>
                    <tr>
                        <td class="title">
                            <img src="{{url($main_settings->image)}}"
                                 style="width: 80%; height: 80px; max-width: 300px"/>
                        </td>

                        <td>
                            <span style="font-weight: bold;font-size: 20px;"># : {{$row->id}}</span><br/>
                            Created: {{$row->created_at->toDayDateTimeString()}}<br/>
                            Date: {{$row->created_at->toDayDateTimeString()}}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="information">
            <td colspan="6">
                <table>
                    <tr>
                        <td>
                            {{--<span style="max-width: 10px;overflow-wrap: break-word;  word-wrap: break-word; hyphens: auto;">{{$main_settings->address}}</span>  <br/>--}}
                            {{$main_settings->address}}<br/>
                            {{$main_settings->email}} -
                            {{$main_settings->phone}}<br/>
                            {{--Sunnyville, CA 12345--}}
                        </td>

                        <td>
                            {{trans('main.organization')}} :{{$row->organization->name ?? ''}}<br/>
                            {{trans('main.project')}} : {{$row->project->name ?? ''}}<br/>
                            {{trans('main.safe')}} : {{$row->safe_transaction->safe->name ?? ''}}<br/>
                            {{--{{$main_settings->email}}<br/>--}}
                            {{--john@example.com--}}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="information">
            <td colspan="6">
                <table>
                    <tr class="col-lg-12">
                        <td class="m-b-md">
                            <h2>{{trans('main.details')}}</h2>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-bottom:0;text-align: left">
                            {{trans('main.payment_status')}}: {{$row->payment_status}}
                        </td>
                        <td style="padding-bottom:0;text-align: left">
                            {{trans('main.transaction_no')}}: {{$row->id}}
                        </td>
                        <td style="padding-bottom:0;text-align: left">
                            {{trans('main.type')}}: {{$row->type}}
                        </td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td style="padding-bottom:0;text-align: left">
                                {{trans('main.date')}}: {{$row->date}}
                        </td>
                        <td style="padding-bottom:0;text-align: left">
                            {{trans('main.organization')}}: {{$row->organization->name ?? ''}}
                        </td>
                        <td style="padding-bottom:0;text-align: left">
                            {{trans('main.project')}}: {{$row->project->name ?? ''}}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-bottom:0;text-align: left">
                            {{trans('main.amount')}}: {{$row->amount}}
                        </td>
                        <td style="padding-bottom:0;text-align: left">
                            {{trans('main.details')}}: {{$row->details}}
                        </td>

                    </tr>
                </table>
            </td>
        </tr>

        <tr class="information">
            <td colspan="6">
                <table>
                    <tr>


                        <td style=" padding-bottom: 10px;">
                            <span style="font-weight: bold;">{{trans('main.submitted_by')}}</span> <br/>
                            {{$row->employee->name ?? ''}}<br/>
                            {{--{{$main_settings->email}}<br/>--}}
                            {{--john@example.com--}}
                        </td>

                        {{--                        <td style="text-align: left;padding-bottom: 10px;">--}}
                        {{--                            <span style="font-weight: bold;">{{trans('main.approved_by')}}</span> <br/>--}}
                        {{--                            <br/>--}}
                        {{--                        </td>--}}
                    </tr>

                    <tr>


                        <td>
                            <span style="font-weight: bold;">{{trans('main.name')}}</span>
                            ......................................
                            <br/>

                            <span style="font-weight: bold;">{{trans('main.signature')}}</span>
                            ................................
                            <br/>
                            {{--{{$main_settings->email}}<br/>--}}
                            {{--john@example.com--}}
                        </td>

                        {{--<td style="text-align: left;">--}}
                        {{--<span style="font-weight: bold;">{{trans('main.signature')}}</span>--}}
                        {{--........... <br/>--}}
                        {{--</td>--}}
                    </tr>
                    {{--<tr>--}}


                    {{--<td>--}}
                    {{--<span style="font-weight: bold;">{{trans('main.signature')}}</span> <br/>--}}
                    {{--........... <br/>--}}
                    {{--<span style="font-weight: bold;">{{trans('main.name')}}</span> <br/>--}}
                    {{--........... <br/>--}}
                    {{--{{$main_settings->email}}<br/>--}}
                    {{--john@example.com--}}
                    {{--</td>--}}

                    {{--<td>--}}

                    {{--</td>--}}
                    {{--</tr>--}}
                </table>
            </td>
        </tr>
        {{--<tr class="total">--}}
        {{--<td>{{trans('main.submitted_by')}}</td>--}}

        {{--<td>:{{$row->amount}}</td>--}}
        {{--</tr>--}}
    </table>
</div>

<script>
    window.print();
    var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
    if (isChrome == false) window.close();
</script>
</body>
</html>
