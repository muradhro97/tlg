@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.users'),'url'=>'user'])
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


                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="user_name">{{trans('main.user_name') }}</label>
                        <input type="text" id="user_name" name="user_name" value="{{request()->user_name}}"
                               placeholder="{{trans('main.user_name') }}"
                               class="form-control">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="email">{{trans('main.email') }}</label>
                        <input type="text" id="email" name="email" value="{{request()->email}}"
                               placeholder="{{trans('main.email') }}"
                               class="form-control">
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
            <h5>{{trans('main.users') }}</h5>
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
            @can('addUser')
            <div class="">
                <a href="{{url('admin/user/create')}}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> {{trans('main.new') }}
                </a>
            </div>
            @endcan
            <div class="clearfix"></div>
            <br>


            @if($rows->count()>0)
                <div class="table-responsive">
                    <table class="data-table table table-bordered">
                        <thead>
                        <th>#</th>
                        <th>{{trans('main.name') }}</th>
                        <th>{{trans('main.user_name') }}</th>
                        <th>{{trans('main.email') }}</th>

                        @can('perUser')
                        <th class="text-center">{{trans('main.permissions') }}</th>
                        @endcan
                        @can('editUser')
                        <th class="text-center">{{trans('main.edit') }}</th>
                        @endcan
                        @can('deleteUser')
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
                                <td>{{$row->user_name}}</td>
                                <td>{{$row->email}}</td>
                                @can('perUser')
                                <td class="text-center"><a href="{{url('admin/permissions/'.$row->id)}}"
                                                           class="btn btn-xs btn-primary"><i class="fa fa-lock"></i></a>
                                </td>
                                @endcan
                                @can('editUser')
                                <td class="text-center"><a href="{{url('admin/user/'.$row->id.'/edit')}}"
                                                           class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a>
                                </td>
                                @endcan
                                @can('deleteUser')
                                <td class="text-center">
                                    {{Form::open(array('method'=>'delete','class'=>'delete','url'=>url('admin/user/'.$row->id) )) }}
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
