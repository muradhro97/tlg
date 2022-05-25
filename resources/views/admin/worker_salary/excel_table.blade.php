<div class="table-responsive">
    <table class="data-table table table-bordered print_table">
        <thead>


        {{--<th class="text-center">{{trans('main.edit') }}</th>--}}
        {{--<th class="text-center">{{trans('main.delete') }}</th>--}}
        </thead>
        <tbody>
        <tr>
            <td>#</td>
            <td>{{trans('main.amount') }}</td>
            <td>{{trans('main.from') }}</td>
            <td>{{trans('main.to') }}</td>
            <td>{{trans('main.manager_status') }}</td>
            <td>{{trans('main.payment_status') }}</td>
            <td>{{trans('main.safe') }}</td>
        </tr>
        @php $count = 1; @endphp
        @foreach($rows as $row)
            <?php
            $iteration = $loop->iteration + 1
            ?>
            <tr>
                <td>{{$iteration}}</td>
                {{--                                <td>{{$row->id}}</td>--}}
                <td>{{$row->amount}}</td>
                {{--                                <td>{{$row->safe_transaction_id ?? ''}}</td>--}}
                <td>{{$row->start}}</td>
                <td>{{$row->end}}</td>
                <td>{{$row->manager_status}}</td>
                <td>{{$row->payment_status}}</td>
                <td>{{$row->safe->name ?? ''}}</td>



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
