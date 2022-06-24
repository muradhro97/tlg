<div class="table-responsive">
    <table class="data-table table table-bordered myTable">
        <thead>
        <th>{{trans('main.select')}}</th>
        {{--                        <th>{{trans('main.transaction_no') }}</th>--}}
        <th>{{trans('main.id') }}</th>
        <th>{{trans('main.name') }}</th>
        <th>{{trans('main.job') }}</th>
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
        <th>{{trans('main.signature') }}</th>

        {{--$sum_net = 0;--}}
        {{--<th class="text-center">{{trans('main.edit') }}</th>--}}
        {{--<th class="text-center">{{trans('main.delete') }}</th>--}}
        </thead>
        <tbody>
        <?php
        $days_sum = 0;
        $daily_salary_sum = 0;
        $total_daily_salary_sum = 0;
        $overtime_sum = 0;
        $hourly_salary_sum = 0;
        $additions_sum = 0;
        $deduction_hrs_sum = 0;
        $deduction_value_sum = 0;
        $safety_sum = 0;
        $discounts_sum = 0;
        $total_sum = 0;
        $sum_net = 0;
        $taxes_sum = 0;
        $insurance_sum = 0;
        ?>
        @php $count = 1; @endphp
        @foreach($rows as $row)
            <?php
            $iteration = $loop->iteration + 1;
            $row_worker_time_sheet = $row->workerTimeSheet()->where('attendance','yes')->whereBetween('date', [request()->from, request()->to])->whereNull('accounting_id');
            if(request()->filled('type')){
                $row_worker_time_sheet = $row_worker_time_sheet->where('type',request()->type);
            }
            $days = $row_worker_time_sheet->count();
            $daily_salary = $row->job->daily_salary;
            $total_daily_salary =$row_worker_time_sheet->sum('daily_salary');
            $overtime = $row_worker_time_sheet->sum('overtime');
            $hourly_salary = $row->job->hourly_salary;
            $additions = $row_worker_time_sheet->sum('additions');
            $deduction_hrs = $row_worker_time_sheet->sum('deduction_hrs');
            $deduction_value = $row_worker_time_sheet->sum('deduction_value');
            $safety = $row_worker_time_sheet->sum('safety');
            $discounts = $row_worker_time_sheet->sum('discounts');
            $total = $row_worker_time_sheet->sum('total');
            $taxes = $row->job->taxes;
            $insurance = $row->job->insurance;

            $days_sum +=$days;
            $daily_salary_sum +=$daily_salary;
            $total_daily_salary_sum +=$total_daily_salary;
            $overtime_sum +=$overtime;
            $hourly_salary_sum +=$hourly_salary;
            $additions_sum +=$additions;
            $deduction_hrs_sum +=$deduction_hrs;
            $deduction_value_sum +=$deduction_value;
            $safety_sum +=$safety;
            $discounts_sum +=$discounts;
            $total_sum +=$total;
            $taxes_sum += $taxes;
            $insurance_sum += $insurance;
            ?>
            <tr>
                <td><input class="checkbox1" type="checkbox" value="{{$row->id}}" name="ids[]"></td>
                {{--                                <td>{{$row->id}}</td>--}}
                <td>{{$row->id}}</td>
                <td>{{$row->name}}</td>
                <td>{{$row->job->name?? '---'}}</td>
                <td>{{$days}}</td>
                <td>{{number_format($daily_salary,2)}}</td>
                <td>{{number_format($total_daily_salary,2)}}</td>
                <td>{{number_format($overtime,2)}}</td>
                <td>{{number_format($row->job->hourly_salary,2)}}</td>
                <td>{{number_format($additions,2)}}</td>
                <td>{{number_format($deduction_hrs,2)}}</td>
                <td>{{number_format($deduction_value,2)}}</td>
                <td>{{$safety}}</td>
                <td>{{number_format($discounts,2)}}</td>
                <td>{{number_format($total,2)}}</td>
                <td>
                    <?php
                    $loans_input = $row->loans()->whereNull('accounting_id')->sum('amount')
                    ?>
                    <input type="number" max="{{$loans_input}}" value="{{$loans_input}}" name="loans[{{$row->id}}]">
                </td>
                <td>{{$taxes}}</td>
                <td>{{$insurance}}</td>
                <?php
                $net = $row_worker_time_sheet->sum('total') - $row->loans()->whereNull('accounting_id')->sum('amount') - $row->job->taxes - $row->job->insurance;
                $sum_net += $net;
                ?>
                <td>{{$net }}</td>
                <td></td>

            </tr>
            @php $count ++; @endphp
        @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td>{{trans('main.total')}}</td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{$days_sum}}</td>
                <td>{{$daily_salary_sum}}</td>
                <td>{{$total_daily_salary_sum}}</td>
                <td>{{$overtime_sum}}</td>
                <td>{{$hourly_salary_sum}}</td>
                <td>{{$additions_sum}}</td>
                <td>{{$deduction_hrs_sum}}</td>
                <td>{{$deduction_value_sum}}</td>
                <td>{{$safety_sum}}</td>
                <td>{{$discounts_sum}}</td>
                <td>{{$total_sum}}</td>
                <td></td>
                <td>{{$taxes_sum}}</td>
                <td>{{$insurance_sum}}</td>
                <td>{{$sum_net}}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>
{{--<div class="text-center">--}}
{{--    {!! $rows->appends(request()->except('page'))->links() !!}--}}
{{--</div>--}}
