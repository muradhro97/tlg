<div class="table-responsive">
    <table class="data-table table table-bordered print_table">
        <thead>


        {{--<th class="text-center">{{trans('main.edit') }}</td>--}}
        {{--<th class="text-center">{{trans('main.delete') }}</td>--}}
        </thead>
        <tbody>
        <tr>
            <td>#</td>
            <td>{{trans('main.date') }}</td>
            <td>{{trans('main.employee') }}</td>
            <td>{{trans('main.attendance') }}</td>
            <td data-hide="all">{{trans('main.project') }}</td>
            <td data-hide="all">{{trans('main.organization') }}</td>
            <td data-hide="all">{{trans('main.department') }}</td>
            <td>{{trans('main.period1_from') }}</td>
            <td>{{trans('main.period1_to') }}</td>
            <td>{{trans('main.period1_hrs') }}</td>
            <td>{{trans('main.period2_from') }}</td>
            <td>{{trans('main.period2_to') }}</td>
            <td>{{trans('main.period2_hrs') }}</td>
            <td>{{trans('main.total_regular') }}</td>
            <td>{{trans('main.overtime') }}</td>
            <td>{{trans('main.total_daily') }}</td>
            <td>{{trans('main.details') }}</td>
        </tr>
        @php $count = 1; @endphp
        @foreach($rows as $row)
            <?php
            $iteration = $loop->iteration + 1
            ?>
            <tr>
                <td>{{$iteration}}</td>
                <td>{{$row->date}}</td>
                <td>{{$row->employee->name ?? ''}}</td>
                <td style="{{!$row->attendance_color?'' : 'border:2px dashed '.$row->attendance_color.''}}">{{$row->attendance}}</td>
                <td>{{$row->employee->project->name ?? ''}}</td>
                <td>{{$row->employee->organization->name ?? ''}}</td>
                <td>{{$row->employee->department->name ?? ''}}</td>
                <td>{{$row->from1}}</td>
                <td>{{$row->to1}}</td>
                <td>{{$row->hrs1}}</td>
                <td>{{$row->from2}}</td>
                <td>{{$row->to2}}</td>
                <td>{{$row->hrs2}}</td>
                <td>{{minToHour($row->total_regular_minutes)}}</td>
                <td>{{minToHour($row->overtime_minutes)}}</td>
                <td>{{minToHour($row->total_daily_minutes)}}</td>
                <td>{{$row->details}}</td>



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
    </table>
</div>
