@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.stock_transactions'),'url'=>'stock-transaction'])
@stop
@inject('item','App\Item')
<?php
$items = $item->latest()->pluck('name', 'id')->toArray();
$typeOptions = [
    'in' => trans('main.in'),
    'out' => trans('main.out'),


];
$moduleOptions = [
    'stock' => 'stock',
    'accounting' => 'accounting',


];
?>
@section('content')
    <div class="ibox ibox-primary">
        <div class="ibox-title">
            <h5>{{trans('main.search') }}</h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
                <a class="close-link">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content m-b-sm border-bottom">

            {!! Form::open([
                  'method' => 'GET'
              ]) !!}
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="type">{{trans('main.type')}}</label>
                        {{Form::select('type', $typeOptions, request()->type, [
                            "class" => "form-control select2 " ,
                            "id" => "type",
                            "placeholder" => trans('main.type')
                        ])}}
                        {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="module">{{trans('main.module')}}</label>
                        {{Form::select('module', $moduleOptions, request()->module, [
                            "class" => "form-control select2 " ,
                            "id" => "module",
                            "placeholder" => trans('main.module')
                        ])}}
                        {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="item_id">{{trans('main.item')}}</label>
                        {{Form::select('item_id', $items, request()->item_id, [
                            "class" => "form-control select2 " ,
                            "id" => "item_id",
                            "placeholder" => trans('main.item')
                        ])}}
                        {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="date">{{trans('main.date')}}</label>
                        <div class="input-group date">

                            {!! Form::text('date',request()->date,[
                                'class' => 'form-control datepicker',
                                'placeholder' => trans('main.date'),

                            ]) !!}
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>


            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-sm-2 ">
                    <div class="form-group">
                        <label for="">&nbsp;</label>
                        <button type="submit" class="btn btn-flat  btn-primary btn-md">{{trans('main.search') }}</button>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <div class="ibox ibox-primary">
        <div class="ibox-title">
            <h5>{{trans('main.stock_transactions') }}</h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
                <a class="close-link">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">
            {{--<div class="">--}}
                {{--<a href="{{url('admin/stock-in')}}" class="btn btn-primary">--}}
                    {{--<i class="fa fa-plus"></i> {{trans('main.stock_in') }}--}}
                {{--</a>--}}
                {{--<a href="{{url('admin/stock-out')}}" class="btn btn-primary">--}}
                    {{--<i class="fa fa-plus"></i> {{trans('main.stock_out') }}--}}
                {{--</a>--}}
            {{--</div>--}}

            <div class="clearfix"></div>
            <br>


            @if($rows->count()>0)
                <div class="table-responsive">
                    <table class="data-table table table-bordered  print_table">
                        <thead>
                        <th>#</th>
                        <th>{{trans('main.transaction_no') }}</th>
                        <th>{{trans('main.stock_order_id') }}</th>
                        <th>{{trans('main.accounting_id') }}</th>
                        <th>{{trans('main.module') }}</th>
                        <th>{{trans('main.date') }}</th>
                        <th>{{trans('main.item') }}</th>
                        <th>{{trans('main.unit') }}</th>
                        <th>{{trans('main.type') }}</th>
                        <th>{{trans('main.old_quantity') }}</th>
                        <th>{{trans('main.quantity') }}</th>
                        <th>{{trans('main.new_quantity') }}</th>


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
                                <td>{{$iteration}}</td>
                                <td>{{$row->id}}</td>
                                <td>{{$row->stock_order_id}}</td>
                                <td>{{$row->accounting_id}}</td>
                                <td>{{$row->module}}</td>
                                <td>{{$row->created_at->toDateString()}}</td>
                                <td>{{$row->item->name ?? ''}}</td>
                                <td>{{$row->item->unit->name ?? '' }}</td>
                                <td>{{$row->type}}</td>

                                <td>{{$row->old_quantity}}</td>
                                <td>{{$row->quantity}}</td>

                                <td>{{$row->new_quantity}}</td>


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
                <div class="text-center">
                    {!! $rows->appends(request()->except('page'))->links() !!}
                </div>
            @else
                <h2 class="text-center">{{trans('main.no_records') }}</h2>
            @endif
            <div class="clearfix"></div>
        </div>
    </div>

    @push('script')

        <script>
            $(document).ready(function () {
                $('.print_table').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'print',
                            className: 'btn btn-primary  hide-for-mobile',
                            {{--text: "<i class=fa fa-print'></i>  {{trans('main.print')}}",--}}
                            text:      '<i class="fa fa-print"></i> {{trans("main.print")}}',
                            autoPrint: true,
                            title: "",
                            init: function(api, node, config) {
                                $(node).removeClass('dt-button')
                            },
                            exportOptions: {
                                columns: [ 0, 1 ,2,3,4,5,6,7,8,9,10,11]
                            }
                        }
                    ],
                    "paging": false,
                    "ordering": false,
                    "searching": false,
                    "info": false
                });
            });

        </script>
    @endpush
@stop