<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    {{--<title>خطاب قبول</title>--}}

    <style>
        .invoice-box {
            max-width: 600px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
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
    <table>
        <tr>


            <td style="padding: 0;">
                <h1>Accept Letter</h1>

            </td>

            <td class="title">
                <img src="{{url($settings->image)}}" style="width:100%; max-width:300px; ">
            </td>
        </tr>
    </table>

    <p>We appreciate attending our interview and we would inform you that you are been qualified and accepted to be one
        of our team
        Please check job description below and reply us within 48 hrs if you accept our offer or not


    </p>
    <table cellpadding="0" cellspacing="0">


        <tr class="information">
            <td >
                <table>
                    <tr>
                        <td>
                            {{trans('main.start_date') }}
                        </td>

                        <td>
{{$row->start_date}}
                        </td>
                        <td>
                            {{trans('main.location') }}
                        </td>

                        <td>
                            {{$row->location}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{trans('main.test_period') }}
                        </td>

                        <td>{{$row->test_period}}</td>
                        <td>
                            {{trans('main.basic_salary') }}
                        </td>

                        <td>
                            {{$row->basic_salary}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{trans('main.test_salary') }}
                        </td>

                        <td>{{$row->test_salary}}</td>
                        <td>
                            {{trans('main.allowances') }}
                        </td>

                        <td>
                            {{$row->allowances}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{trans('main.job_description') }}
                        </td>

                        <td>{{$row->job_description}}</td>
                        <td>
                            {{trans('main.papers_needed') }}
                        </td>

                        <td>
                            {{$row->papers_needed}}
                        </td>
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
    <p> If you have any quesition Contact us at {{$settings->phone}} or  {{$settings->email}}</p>
</div>
<script>
    window.print();
    var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
    if (isChrome == false) window.close();
</script>
</body>
</html>
