@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.organizations'),'url'=>'organization'])
@stop
@section('content')
    @inject('category','App\Category')

    @php
        $types = [
       'owner' => trans('main.owner') ,
       'mainContractor' => trans('main.main_contractor') ,
       'subContractor' => trans('main.sub_contractor') ,
       'supplier' => trans('main.supplier') ,


   ];
    @endphp
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
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="phone">{{trans('main.phone') }}</label>
                        <input type="text" id="phone" name="phone" value="{{request()->phone}}"
                               placeholder="{{trans('main.phone') }}"
                               class="form-control">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="type">{{trans('main.type') }}</label>
                        {{Form::select('type', $types, request()->type, [
                              "class" => "form-control select2 " ,
                              "id" => "type",
                              "placeholder" => trans('main.type')
                          ])}}
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
            <h5>{{trans('main.organizations') }}</h5>
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
            @can('addOrganization')
                <div class="">
                    <a href="{{url('admin/organization/create')}}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> {{trans('main.new') }}
                    </a>
                </div>
            @endcan
            <div class="clearfix"></div>
            <br>


            @if($rows->count()>0)
                <div class="table-responsive">
                    <table class="footable  table table-bordered toggle-arrow-tiny" data-sort="false">
                        <thead>
                        <th data-toggle="true">#</th>
                        <th>{{trans('main.name') }}</th>
                        <th>{{trans('main.code') }}</th>
                        <th>{{trans('main.phone') }}</th>
                        <th data-hide="all">{{trans('main.tax_no') }}</th>
                        <th data-hide="all">{{trans('main.commercial_no') }}</th>
                        <th>{{trans('main.type') }}</th>
                        <th data-hide="all">{{trans('main.address') }}</th>
                        @can('editOrganization')
                            <th class="text-center">{{trans('main.edit') }}</th>
                        @endcan
                        @can('deleteOrganization')
                            <th class="text-center">{{trans('main.delete') }}</th>
                        @endcan
                        </thead>
                        <tbody>
                        @php $count = 1; @endphp
                        @foreach($rows as $row)
                            <?php
                            $iteration = $loop->iteration + (($rows->currentPage() - 1) * $rows->perPage())
                            ?>
                            <tr>
                                <td>{{$iteration}}</td>
                                <td>{{$row->name}}</td>
                                <td>{{$row->code}}</td>
                                <td>{{$row->phone}}</td>
                                <td>{{$row->tax_no}}</td>
                                <td>{{$row->commercial_no}}</td>
                                <td>{{$row->type}}</td>
                                <td>{{$row->address}}</td>
                                @can('editOrganization')
                                    <td class="text-center"><a href="{{url('admin/organization/'.$row->id.'/edit')}}"
                                                               class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a>
                                    </td>
                                @endcan
                                @can('deleteOrganization')
                                    <td class="text-center">
                                        {{Form::open(array('method'=>'delete','class'=>'delete','url'=>url('admin/organization/'.$row->id) )) }}
                                        <button type="submit" class="destroy btn btn-danger btn-xs"><i
                                                    class="fa fa-trash-o"></i></button>
                                        {{Form::close()}}
                                    </td>
                                @endcan
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
@stop
