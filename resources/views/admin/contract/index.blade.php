@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.contracts'),'url'=>'contract'])
@stop
@section('content')
@inject('organization','App\Organization')
@inject('project','App\Project')
@inject('contractType','App\ContractType')




<?php


$organizations = $organization->latest()->pluck('name', 'id')->toArray();


$projects = $project->latest()->whereIn('id', auth()->user()->projects->pluck('id')->toArray())->pluck('name', 'id')->toArray();
$contractTypes = $contractType->latest()->pluck('name', 'id')->toArray();
$statusOptions = [

    'notStart' => trans('main.notStart'),
    'active' => trans('main.active'),
    'onhold' => trans('main.onhold'),
    'closed' => trans('main.closed'),
    'extended' => trans('main.extended'),


];
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
                        <label class="control-label" for="status">{{trans('main.status')}}</label>
                        {{Form::select('status', $statusOptions, request()->status, [
                            "class" => "form-control select2 " ,
                            "id" => "status",
                            "placeholder" => trans('main.status')
                        ])}}
                        {{--<input type="text" id="status" name="status" value="" placeholder="Status" class="form-control">--}}
                    </div>
                </div>


                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="date">{{trans('main.from')}}</label>
                        <div class="input-group date">

                            {!! Form::text('from',request()->from,[
                                'class' => 'form-control ',
                                'placeholder' => trans('main.from'),
                                 "id" => 'filter-from'
                            ]) !!}
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="to">{{trans('main.to')}}</label>
                        <div class="input-group date">

                            {!! Form::text('to',request()->to,[
                                'class' => 'form-control ',
                                'placeholder' => trans('main.to'),
                                 "id" => 'filter-to'
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
            <h5>{{trans('main.contracts') }}</h5>
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
            @can('addContract')
                <div class="">
                    <a href="{{url('admin/contract/create')}}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> {{trans('main.new') }}
                    </a>
                </div>
            @endcan
            <div class="clearfix"></div>
            <br>


            @if($rows->count()>0)
                <div class="table-responsive">
                    <table class="footable table table-bordered toggle-arrow-tiny print_table " data-sort="false">
                        <thead>
                        <th>#</th>
                        <th>{{trans('main.no') }}</th>
                        <th>{{trans('main.organization') }}</th>
                        <th>{{trans('main.project') }}</th>
                        <th>{{trans('main.date') }}</th>
                        <th >{{trans('main.type') }}</th>
                        <th >{{trans('main.status') }}</th>
                        <th >{{trans('main.price') }}</th>
                        <th >{{trans('main.duration') }}</th>
                        <th>{{trans('main.start_date') }}</th>
                        <th>{{trans('main.finish_date') }}</th>
                        <th class="text-center">{{trans('main.show') }}</th>
                        @can('editContract')
                            <th class="text-center">{{trans('main.edit') }}</th>
                        @endcan
                        @can('deleteContract')
                            <th class="text-center">{{trans('main.delete') }}</th>
                        @endcan
                        </thead>
                        <tbody>

                        @foreach($rows as $row)
                            <?php
                            $iteration = $loop->iteration + (($rows->currentPage() - 1) * $rows->perPage())
                            ?>
                            <tr>
                                <td>{{$iteration}}</td>
                                <td>{{$row->no}}</td>
                                <td>{{$row->organization->name ?? '...'}}</td>
                                <td>{{$row->project->name ?? '...'}}</td>
                                <td>{{$row->date}}</td>
                                <td>{{$row->contractType->name ?? '...'}}</td>
                                <td>{{$row->status}}</td>
                                <td>{{$row->price}}</td>
                                <td>{{$row->duration}}</td>
                                <td>{{$row->start_date}}</td>
                                <td>{{$row->finish_date}}</td>
                                <td class="text-center">

                                    <a style="margin: 2px;" type="button" href="{{url('admin/contract/'.$row->id)}}"
                                       class="btn btn-xs btn-primary"><i
                                                class="fa fa-eye"></i></a>
                                </td>
                                @can('editContract')
                                <td class="text-center"><a href="{{url('admin/contract/'.$row->id.'/edit')}}"
                                                           class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a>
                                </td>
                                @endcan
                                @can('deleteContract')
                                <td class="text-center">
                                    {{Form::open(array('method'=>'delete','class'=>'delete','url'=>url('admin/contract/'.$row->id) )) }}
                                    <button type="submit" class="destroy btn btn-danger btn-xs"><i
                                                class="fa fa-trash-o"></i></button>
                                    {{Form::close()}}
                                </td>
                                @endcan
                            </tr>

                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="7"></td>
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
                            text:      '<i class="fa fa-print"></i> {{trans("main.print")}}',
                            autoPrint: true,
                            title: "",
                            init: function(api, node, config) {
                                $(node).removeClass('dt-button')
                            },
                            exportOptions: {
                                columns: [ 0, 1 ,2,3,4,5,6,7,8,9,10]
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
