@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.extracts'),'url'=>'extract'])
@stop
@section('content')

    @inject('organization','App\Organization')
    @inject('project','App\Project')
    @inject('contractType','App\ContractType')
    @inject('subContract','App\SubContract')




    <?php


    $organizations = $organization->where('type', 'subContractor')->latest()->pluck('name', 'id')->toArray();


    $projects = $project->latest()->whereIn('id', auth()->user()->projects->pluck('id')->toArray())->pluck('name', 'id')->toArray();
    $contractTypes = $contractType->latest()->pluck('name', 'id')->toArray();

    $subContracts = $subContract->latest()->pluck('no', 'id')->toArray();
    ?>
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
                        <label class="control-label" for="project_id">{{trans('main.project')}}</label>
                        {{Form::select('project_id', $projects, request()->project_id, [
                            "class" => "form-control select2 " ,
                            "id" => "project_id",
                            "placeholder" => trans('main.project')
                        ])}}
                        {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="organization_id">{{trans('main.organization')}}</label>
                        {{Form::select('organization_id', $organizations, request()->organization_id, [
                            "class" => "form-control select2 " ,
                            "id" => "organization_id",
                            "placeholder" => trans('main.organization')
                        ])}}
                        {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="type_id">{{trans('main.type')}}</label>
                        {{Form::select('type_id', $contractTypes, request()->type_id, [
                            "class" => "form-control select2 " ,
                            "id" => "type_id",
                            "placeholder" => trans('main.type')
                        ])}}
                        {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="type_id">{{trans('main.sub_contract')}}</label>
                        {{Form::select('sub_contract_id', $subContracts, request()->sub_contract_id, [
                            "class" => "form-control select2 " ,
                            "id" => "sub_contract_id",
                            "placeholder" => trans('main.sub_contract')
                        ])}}
                        {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="date">{{trans('main.from')}}</label>
                        <input type="date" id="date" name="date_from" value="" placeholder="{{trans('main.date')}}"
                               class="form-control">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="date">{{trans('main.to')}}</label>
                        <input type="date" id="date" name="date_to" value="" placeholder="{{trans('main.date')}}"
                               class="form-control">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="amount_from">{{trans('main.amount_from')}}</label>
                        <div class="input-group clockpicker" data-autoclose="true">
                            <input type="number" step="0.01" name="amount_from" class="form-control"
                                   placeholder="{{trans('main.amount_from')}}" value="{{old('amount_from')}}">
                            <span class="input-group-addon">
                                <span class="fa fa-usd"></span>
                            </span>
                        </div>
                        {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="amount_to">{{trans('main.amount_to')}}</label>
                        <div class="input-group clockpicker" data-autoclose="true">
                            <input type="number" step="0.01" name="amount_to" class="form-control"
                                   placeholder="{{trans('main.amount_to')}}" value="{{old('amount_to')}}">
                            <span class="input-group-addon">
                                <span class="fa fa-usd"></span>
                            </span>
                        </div>
                        {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
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
            <h5>{{trans('main.extracts') }}</h5>
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
            @can('addExtract')
                <div class="">
                    <a href="{{url('admin/extract/create')}}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> {{trans('main.new') }}
                    </a>
                </div>
            @endcan
            <div class="clearfix"></div>
            <br>


            @if($rows->count()>0)
                <div class="table-responsive">
                    <table class="data-table table table-bordered  print_table">
                        <thead>
                        <th>#</th>
                        <th>{{trans('main.number') }}</th>

                        {{--                        <th>{{trans('main.transaction_no') }}</th>--}}
                        <th>{{trans('main.date') }}</th>
                        <th>{{trans('main.sub_contract') }}</th>
                        <th>{{trans('main.contract_type') }}</th>
                        {{--                        <th>{{trans('main.custody_transaction_no') }}</th>--}}
                        <th>{{trans('main.organization') }}</th>
                        <th>{{trans('main.project') }}</th>
                        <th>{{trans('main.period_from') }}</th>
                        <th>{{trans('main.period_to') }}</th>
                        <th>{{trans('main.extract_value') }}</th>


                        <th>{{trans('main.options') }}</th>

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
                                <td>{{$row->number}}</td>

                                {{--                                <td>{{$row->id}}</td>--}}
                                <td>{{$row->date}}</td>
                                <td>{{$row->subContract->no ?? ''}}</td>

                                {{--                                <td>{{$row->safe_transaction_id ?? ''}}</td>--}}
                                <td>{{$row->subContract->contractType->name ?? ''}}</td>
                                <td>{{$row->organization->name ?? ''}}</td>
                                <td>{{$row->project->name ?? ''}}</td>

                                {{--<td>{{$row->balance}}</td>--}}
                                {{--<td>{{$row->new_balance}}</td>--}}
                                <td>{{$row->period_from}}</td>
                                <td>{{$row->period_to}}</td>
                                <td>{{number_format($row->total,2)}}</td>

                                <td>

                                    <a style="margin: 2px;" type="button" href="{{url('admin/extract/'.$row->id)}}"
                                       class="btn btn-sm btn-primary"><i
                                            class="fa fa-eye"></i></a>
                                    @can('editExtract')
                                        <a href="{{route('extract.edit',$row->id)}}" class="btn btn-sm btn-success">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    @endcan
                                </td>

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
                            <td colspan="9"></td>
                            <td>{{$total}}</td>
                        </tr>
                        </tfoot>
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
                            text: '<i class="fa fa-print"></i> {{trans("main.print")}}',
                            autoPrint: true,
                            title: "",
                            init: function (api, node, config) {
                                $(node).removeClass('dt-button')
                            },
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6, 7]
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
