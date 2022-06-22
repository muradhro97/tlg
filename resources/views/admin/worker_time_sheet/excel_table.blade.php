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
            <td>{{trans('main.attendance') }}</td>
            <td>{{trans('main.worker') }}</td>
            <td>{{trans('main.job') }}</td>
            <td data-hide="all">{{trans('main.project') }}</td>
            <td data-hide="all">{{trans('main.organization') }}</td>
            <td data-hide="all">{{trans('main.department') }}</td>
            <td data-hide="all">{{trans('main.labors_group') }}</td>
            {{--<td>{{trans('main.type') }}</td>--}}
            {{--<td>{{trans('main.productivity') }}</td>--}}
            {{--<td>{{trans('main.unit_price') }}</td>--}}
            <td>{{trans('main.overtime') }}</td>
            <td>{{trans('main.overtime') }}2</td>
            <td>{{trans('main.deduction_hrs') }}</td>
            <td>{{trans('main.deduction_value') }}</td>
            <td>{{trans('main.safety') }}</td>
            <td>{{trans('main.additions') }}</td>
            <td>{{trans('main.discounts') }}</td>
            <td>{{trans('main.total') }}</td>
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
                <td>{{$row->attendance}}</td>
                <td>{{$row->worker->name ?? ''}}</td>
                <td>{{$row->worker->job->name ?? ''}}</td>
                <td>{{$row->worker->project->name ?? ''}}</td>
                <td>{{$row->worker->organization->name ?? ''}}</td>
                <td>{{$row->worker->department->name ?? ''}}</td>
                <td>{{$row->worker->group->name ?? ''}}</td>
                {{--<td>{{$row->type}}</td>--}}
                {{--<td>{{$row->productivity}}</td>--}}
                {{--<td>{{$row->unit_price}}</td>--}}
                <td>{{$row->overtime}}</td>
                <td>{{$row->additional_overtime}}</td>
                <td>{{$row->deduction_hrs}}</td>
                <td>{{$row->deduction_value}}</td>
                <td>{{$row->safety}}</td>
                <td>{{$row->additions}}</td>
                <td>{{$row->discounts}}</td>
                <td>{{$row->total}}</td>
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
