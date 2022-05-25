<div class="table-responsive">
    <table class="data-table table table-bordered print_table">
        <thead>


        {{--<th class="text-center">{{trans('main.edit') }}</th>--}}
        {{--<th class="text-center">{{trans('main.delete') }}</th>--}}
        </thead>
        <tbody>
        <tr>
            <td>#</td>
            <td>{{trans('main.name') }}</td>
            <td>{{trans('main.organization') }}</td>
            <td>{{trans('main.project') }}</td>
            <td>{{trans('main.department') }}</td>
            <td>{{trans('main.labors_groups') }}</td>
            <td>{{trans('main.working_status') }}</td>
            <td>{{trans('main.social_status') }}</td>
            <td>{{trans('main.military_status') }}</td>
            <td>{{trans('main.address') }}</td>
            <td>{{trans('main.id') }}</td>
            <td>{{trans('main.mobile') }}</td>
            <td>{{trans('main.nationality_no') }}</td>
        </tr>
        @php $count = 1; @endphp
        @foreach($rows as $row)
            <?php
            $iteration = $loop->iteration + 1
            ?>
            <tr>
                <td>{{$iteration}}</td>
                {{--                                <td>{{$row->id}}</td>--}}
                <td>{{$row->name}}</td>
                {{--                                <td>{{$row->safe_transaction_id ?? ''}}</td>--}}
                <td>{{$row->organization->name ?? ''}}</td>
                <td>{{$row->project->name ?? ''}}</td>
                <td>{{$row->department->name ?? ''}}</td>
                <td>{{$row->group->name ?? ''}}</td>
                <td>{{$row->working_status}}</td>
                <td>{{$row->social_status}}</td>
                <td>{{$row->military_status}}</td>
                <td>{{$row->address}}</td>
                <td>{{$row->unique_no}}</td>
                <td>{{$row->mobile}}</td>
                <td>{{$row->nationality_no}}</td>



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
