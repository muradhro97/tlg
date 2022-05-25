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

        <h1>{{trans('main.employee')}}  {{$row->name}} ({{$row->working_status_display}})</h1>

        <tr class="information">
            <td >
                <table>
                    <tr>
                        <td>
                            {{trans('main.name') }}
                        </td>

                        <td>
                            {{$row->name}}
                        </td>

                        <td>
                            {{trans('main.job') }}
                        </td>

                        <td>
                            {{$row->job->name ?? ''}}
                        </td>

                    </tr>
                    <tr>

                        <td>
                            {{trans('main.email') }}
                        </td>

                        <td>
                            {{$row->email}}
                        </td>


                        <td>
                            {{trans('main.mobile') }}
                        </td>

                        <td>
                            {{$row->mobile}}
                        </td>
                    </tr>
                    <tr>

                        <td>
                            {{trans('main.organization') }}
                        </td>

                        <td>
                            {{$row->organization->name ?? ''}}
                        </td>


                        <td>
                            {{trans('main.project') }}
                        </td>

                        <td>
                            {{$row->project->name ?? ''}}
                        </td>
                    </tr>
                    <tr>

                        <td>
                            {{trans('main.birth_date') }}
                        </td>

                        <td>
                            {{$row->birth_date}}
                        </td>


                        <td>
                            {{trans('main.gender') }}
                        </td>

                        <td>
                            {{$row->gender_display}}
                        </td>
                    </tr>
                    <tr>

                        <td>
                            {{trans('main.nationality') }}
                        </td>

                        <td>
                            {{$row->country->nationality ?? ''}}
                        </td>


                        <td>
                            {{trans('main.bank') }}
                        </td>

                        <td>
                            {{$row->bank->name ?? '' }}
                        </td>
                    </tr>
                    <tr>

                        <td>
                            {{trans('main.university') }}
                        </td>

                        <td>
                            {{$row->university->name ?? ''}}
                        </td>


                        <td>
                            {{trans('main.nationality_no') }}
                        </td>

                        <td>
                            {{$row->nationality_no }}
                        </td>
                    </tr>
                    <tr>

                        <td>
                            {{trans('main.bank_account') }}
                        </td>

                        <td>
                            {{$row->bank_account}}
                        </td>


                        <td>
                            {{trans('main.department') }}
                        </td>

                        <td>
                            {{$row->department->name ?? ''}}
                        </td>
                    </tr>
                    <tr>

                        <td>
                            {{trans('main.qualification_title') }}
                        </td>

                        <td>
                            {{$row->qualification_title}}
                        </td>


                        <td>
                            {{trans('main.university') }}
                        </td>

                        <td>
                            {{$row->university->name ?? ''}}
                        </td>
                    </tr>
                    <tr>

                        <td>
                            {{trans('main.graduation_year') }}
                        </td>

                        <td>
                            {{$row->graduation_year}}
                        </td>


                        <td>
                            {{trans('main.bank_name') }}
                        </td>

                        <td>
                            {{$row->bank->name ?? ''}}
                        </td>
                    </tr>
                    <tr>

                        <td>
                            {{trans('main.bank_account') }}
                        </td>

                        <td>
                            {{$row->bank_account}}
                        </td>


                        <td>
                            {{trans('main.start_salary') }}
                        </td>

                        <td>
                            {{$row->start_salary}}
                        </td>
                    </tr>
                    <tr>

                        <td>
                            {{trans('main.current_salary') }}
                        </td>

                        <td>
                            {{$row->current_salary}}
                        </td>


                        <td>
                            {{trans('main.university') }}
                        </td>

                        <td>
                            {{$row->university->name ?? ''}}
                        </td>
                    </tr>
                    <tr>

                        <td>
                            {{trans('main.insurance') }}
                        </td>

                        <td>
                            {{$row->insurance}}
                        </td>


                        <td>
                            {{trans('main.taxes') }}
                        </td>

                        <td>
                            {{$row->taxes}}
                        </td>
                    </tr>

                    <tr>

                        <td>
                            {{trans('main.meals') }}
                        </td>

                        <td>
                            {{$row->meals}}
                        </td>


                        <td>
                            {{trans('main.communications') }}
                        </td>

                        <td>
                            {{$row->communications}}
                        </td>
                    </tr>
                    <tr>

                        <td>
                            {{trans('main.transports') }}
                        </td>

                        <td>
                            {{$row->transports}}
                        </td>


                        <td>
                            {{trans('main.hourly_salary') }}
                        </td>

                        <td>
                            {{$row->hourly_salary}}
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

</div>
<script>
    window.print();
    var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
    if (isChrome == false) window.close();
</script>
</body>
</html>
