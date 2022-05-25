<div class="table-responsive">
    <table class="data-table table table-bordered">
        <thead>
        <th>{{trans('main.select')}}</th>
        {{--                        <th>{{trans('main.transaction_no') }}</th>--}}
        <th>{{trans('main.id') }}</th>
        <th>{{trans('main.name') }}</th>
        {{--                        <th>{{trans('main.contract_type') }}</th>--}}
        {{--                        <th>{{trans('main.custody_transaction_no') }}</th>--}}
        <th>{{trans('main.days') }}</th>
        <th>{{trans('main.current_daily_salary') }}</th>
        <th>{{trans('main.total_daily_salary') }}</th>
        <th>{{trans('main.overtime') }}({{trans('main.hours')}})</th>
        <th>{{trans('main.current_hourly_salary') }}</th>
        <th>{{trans('main.additions') }}</th>
        <th>{{trans('main.deduction_hrs') }}</th>
        <th>{{trans('main.deduction_value') }}</th>
        <th>{{trans('main.safety') }}</th>
        <th>{{trans('main.discounts') }}</th>
        <th>{{trans('main.total') }}</th>
        <th>{{trans('main.loans') }}</th>
        <th>{{trans('main.taxes') }}</th>
        <th>{{trans('main.insurance') }}</th>
        <th>{{trans('main.net') }}</th>

        {{--$sum_net = 0;--}}
        {{--<th class="text-center">{{trans('main.edit') }}</th>--}}
        {{--<th class="text-center">{{trans('main.delete') }}</th>--}}
        </thead>
        <tbody>
        @php $count = 1; @endphp
        @foreach($rows as $row)
            <?php
            $iteration = $loop->iteration + (($rows->currentPage() - 1) * $rows->perPage())
            ?>
            <tr>
                <td><input type="checkbox" value="{{$row->id}}" name="ids[]"></td>
                {{--                                <td>{{$row->id}}</td>--}}
                <td>{{$row->id}}</td>
                <td>{{$row->name}}</td>
                <td>{{$row->workerTimeSheet()->where('attendance','yes')->whereBetween('date', [request()->from, request()->to])->whereNull('accounting_id')->count()}}</td>
                <td>{{$row->job->daily_salary}}</td>
                <td>{{$row->workerTimeSheet()->where('attendance','yes')->whereBetween('date', [request()->from, request()->to])->whereNull('accounting_id')->sum('daily_salary')}}</td>
                <td>{{$row->workerTimeSheet()->where('attendance','yes')->whereBetween('date', [request()->from, request()->to])->whereNull('accounting_id')->sum('overtime')}}</td>
                <td>{{$row->job->hourly_salary}}</td>
                <td>{{$row->workerTimeSheet()->where('attendance','yes')->whereBetween('date', [request()->from, request()->to])->whereNull('accounting_id')->sum('additions')}}</td>
                <td>{{$row->workerTimeSheet()->where('attendance','yes')->whereBetween('date', [request()->from, request()->to])->whereNull('accounting_id')->sum('deduction_hrs')}}</td>
                <td>{{$row->workerTimeSheet()->where('attendance','yes')->whereBetween('date', [request()->from, request()->to])->whereNull('accounting_id')->sum('deduction_value')}}</td>
                <td>{{$row->workerTimeSheet()->where('attendance','yes')->whereBetween('date', [request()->from, request()->to])->whereNull('accounting_id')->sum('safety')}}</td>
                <td>{{$row->workerTimeSheet()->where('attendance','yes')->whereBetween('date', [request()->from, request()->to])->whereNull('accounting_id')->sum('discounts')}}</td>
                <td>{{$row->workerTimeSheet()->where('attendance','yes')->whereBetween('date', [request()->from, request()->to])->whereNull('accounting_id')->sum('total')}}</td>
                <td>{{$row->loans()->whereNull('accounting_id')->sum('amount')}}</td>
                <td>{{$row->job->taxes}}</td>
                <td>{{$row->job->insurance}}</td>
                <?php
                $net = $row->workerTimeSheet()->where('attendance', 'yes')->whereBetween('date', [request()->from, request()->to])->whereNull('accounting_id')->sum('total') - $row->loans()->sum('amount') - $row->job->taxes - $row->job->insurance
                //                                $sum_net += $net;
                ?>
                <td>{{$net }}</td>


            </tr>
            @php $count ++; @endphp
        @endforeach
        </tbody>
    </table>
</div>
<div class="text-center">
    {!! $rows->appends(request()->except('page'))->links() !!}
</div>