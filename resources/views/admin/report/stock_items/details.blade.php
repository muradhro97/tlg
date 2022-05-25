@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.items'),'url'=>'item'])
@stop
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
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="name">{{trans('main.name') }}</label>
                        <input type="text" id="name" name="name" value="{{request()->name}}"
                               placeholder="{{trans('main.name') }}"
                               class="form-control">
                    </div>
                </div>


            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-sm-2 ">
                    <div class="form-group">
                        <label for="">&nbsp;</label>
                        <button type="submit"
                                class="btn btn-flat  btn-primary btn-md">{{trans('main.search') }}</button>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <div class="ibox ibox-primary">
        <div class="ibox-title">
            <h5>{{trans('main.quantities') }}</h5>
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

            <div class="clearfix"></div>
            <br>


            @if($item_quantities->count()>0)
                <div class="table-responsive">
                    <table class="data-table table table-bordered myTable">
                        <thead>
                        <th>#</th>
                        <th>{{trans('main.quantity') }}</th>
                        <th>{{trans('main.color') }}</th>
                        <th>{{trans('main.size') }}</th>
                        <th>{{trans('main.price') }}</th>

                        </thead>
                        <tbody>
                        @php $count = 1; @endphp
                        @foreach($item_quantities as $row)
                            <?php
                            $iteration = $loop->iteration + (($item_quantities->currentPage() - 1) * $item_quantities->perPage())
                            ?>
                            <tr>
                                <td>{{$iteration}}</td>
                                <td>{{$row->quantity}}</td>
                                <td>{{$row->color->color ?? ''}}</td>
                                <td>{{$row->size->size}}</td>
                                <td>{{$row->is_priced? number_format($row->price,2) : "---"}}</td>

                            </tr>
                            @php $count ++; @endphp
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-center">
                    {!! $item_quantities->appends(request()->except('page'))->links() !!}
                </div>
            @else
                <h2 class="text-center">{{trans('main.no_records') }}</h2>
            @endif
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="ibox ibox-primary">
        <div class="ibox-title">
            <h5>{{trans('main.stock_history') }}</h5>
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

            <div class="clearfix"></div>
            <br>


            @if($item_stock_details->count()>0)
                <div class="table-responsive">
                    <table class="data-table table table-bordered myTable">
                        <thead>
                        <th>#</th>
                        <th>{{trans('main.date') }}</th>
                        <th>{{trans('main.price') }}</th>
                        <th>{{trans('main.quantity') }}</th>
                        <th>{{trans('main.size') }}</th>
                        <th>{{trans('main.color') }}</th>
                        <th>{{trans('main.total') }}</th>
                        <th>{{trans('main.net') }}</th>
                        </thead>
                        <tbody>
                        @php $count = 1; @endphp
                        @foreach($item_stock_details as $row)
                            <?php
                            $iteration = $loop->iteration + (($item_stock_details->currentPage() - 1) * $item_stock_details->perPage())
                            ?>
                            <tr>
                                <td>{{$iteration}}</td>
                                <td>{{$row->created_at}}</td>
                                <td>{{number_format($row->price,2)}}</td>
                                <td>{{number_format($row->quantity)}}</td>
                                <td>{{$row->size}}</td>
                                <td>{{$row->color}}</td>
                                <td>{{number_format($row->price * $row->quantity,2)}}</td>
                                <td>{{number_format($row->net ,2)}}</td>

                            </tr>
                            @php $count ++; @endphp
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td>TOTAL</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{number_format($row->sum('net'),2)}}</td>
                        </tr>
                        </tfoot>

                    </table>
                </div>
                <div class="text-center">
                    {!! $item_stock_details->appends(request()->except('page'))->links() !!}
                </div>
            @else
                <h2 class="text-center">{{trans('main.no_records') }}</h2>
            @endif
            <div class="clearfix"></div>
        </div>
    </div>

@stop
