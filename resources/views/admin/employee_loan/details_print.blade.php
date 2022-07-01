<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    {{--<title>خطاب قبول</title>--}}

    <style>
        @media print {
            
        }
        .signature{

            direction: rtl;
            padding: 25px;

        }

        table{

        display: table !important;
        border-collapse: separate !important;
        box-sizing: border-box !important;
        text-indent: initial !important;
        border-spacing: 2px !important;
        border-color: grey !important;
        border: 1px solid #EBEBEB !important;
        }
        td , th , tr {
        border-color: grey !important;
        border: 1px solid #EBEBEB;
        }
    </style>
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
    <div class="text-center">
        <img src="{{url( '/uploads/settings/162820501295696.jpg') }}" style="margin-bottom: 15px;" height="100" width="200" alt="logo">

    </div>
<div style="text-align: center;font-size:30px;padding:30px;">
    employee Loans
</div>

    <div class="table-responsive">
        <table class=" data-table table table-bordered  print_table">
            
            <thead>
                    {{-- <th>#</th> --}}
                    <th>{{trans('main.id') }}</th>
                    <th>{{trans('main.date') }}</th>
                    <th>{{trans('main.employee') }}</th>
                    <th>{{trans('main.amount') }}</th>
                    {{--                        <th>{{trans('main.custody_transaction_no') }}</th>--}}
                    {{--<th>{{trans('main.project') }}</th>--}}
                    {{--<th>{{trans('main.organization') }}</th>--}}
                    {{--<th>{{trans('main.contract') }}</th>--}}
                    <th>{{trans('main.safe') }}</th>
                    {{--<th>{{trans('main.safe_balance') }}</th>--}}
                    {{--<th>{{trans('main.safe_new_balance') }}</th>--}}
                    <th>{{trans('main.manager_status') }}</th>
                    <th>{{trans('main.payment_status') }}</th>

            {{--<th class="text-center">{{trans('main.edit') }}</th>--}}
            {{--<th class="text-center">{{trans('main.delete') }}</th>--}}
            </thead>
            <tbody>
            @php $count = 1; @endphp
            @foreach($rows as $row)

                <tr>

                    <td>{{$row->id}}</td>
                    <td>{{$row->date}}</td>
                    <td>{{$row->employee->name ?? ''}}</td>
                    <td>{{number_format($row->amount,2)}}</td>
                    {{--                                <td>{{$row->safe_transaction_id ?? ''}}</td>--}}
                    {{--<td>{{$row->project->name ?? ''}}</td>--}}
                    {{--<td>{{$row->organization->name ?? ''}}</td>--}}
                    {{--<td>{{$row->contract->no ?? ''}}</td>--}}
                    <td>{{$row->safe->name ?? ''}}</td>
                    {{--<td>{{$row->balance}}</td>--}}
                    {{--<td>{{$row->new_balance}}</td>--}}
                    <td>{{$row->manager_status}}</td>
                    <td>{{$row->payment_status}}</td>

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
                @php $count ++; @endphp
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td colspan="4" style="font-weight: bold"> total </td>
                <td>{{$total}}</td>
            </tr>
            </tfoot>
        </table>
            <div class="signature">
                <td  style="font-weight: bold;direction: rtl;float: right;"> التوقيع </td>
                <td>-------------</td>
            </div>

            <div class="signature">
                <td  style="font-weight: bold;direction: rtl;float: right;"> الاعتماد </td>
                <td>-------------</td>
            </div>

    </div>
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
