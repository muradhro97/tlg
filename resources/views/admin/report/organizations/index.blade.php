@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.organization cred/debt'),'url'=>'reports/custody'])
@stop
@section('content')
{{--    <div class="ibox ibox-primary">--}}
{{--        <div class="ibox-title">--}}
{{--            <h5>{{trans('main.search') }}</h5>--}}
{{--            <div class="ibox-tools">--}}
{{--                <a class="collapse-link">--}}
{{--                    <i class="fa fa-chevron-up"></i>--}}
{{--                </a>--}}
{{--                <a class="close-link">--}}
{{--                    <i class="fa fa-times"></i>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="ibox-content m-b-sm border-bottom">--}}

{{--            {!! Form::open([--}}
{{--                  'method' => 'GET'--}}
{{--              ]) !!}--}}
{{--            <div class="row">--}}
{{--                <div class="col-sm-4">--}}
{{--                    <div class="form-group">--}}
{{--                        <label class="control-label" for="name">{{trans('main.name') }}</label>--}}
{{--                        <input type="text" id="name" name="name" value="{{request()->name}}"--}}
{{--                               placeholder="{{trans('main.name') }}"--}}
{{--                               class="form-control">--}}
{{--                    </div>--}}
{{--                </div>--}}


{{--            </div>--}}
{{--            <div class="clearfix"></div>--}}
{{--            <div class="row">--}}
{{--                <div class="col-sm-2 ">--}}
{{--                    <div class="form-group">--}}
{{--                        <label for="">&nbsp;</label>--}}
{{--                        <button type="submit"--}}
{{--                                class="btn btn-flat  btn-primary btn-md">{{trans('main.search') }}</button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            {!! Form::close() !!}--}}
{{--        </div>--}}
{{--    </div>--}}
    <div class="ibox ibox-primary">
        <div class="ibox-title">
            <h5>{{trans('main.organization cred/debt') }}</h5>
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


            @if($rows->count()>0)
                <div class="table-responsive">
                    <table class="data-table table table-bordered myTable">
                        <thead>
                        <th>#</th>
                        <th>{{trans('main.name') }}</th>
                        <th>{{trans('main.creditor') }}</th>
                        <th>{{trans('main.debtor') }}</th>
                        <th>{{trans('main.details') }}</th>
                        </thead>
                        <tbody>
                        @php $count = 1; @endphp
                        @foreach($rows as $row)
                            <?php
                            $iteration = $loop->iteration
                            ?>
                            <tr>
                                <td>{{$iteration}}</td>
                                <td>{{$row->name}}</td>
                                <td>{{$row->total_creditor}}</td>
                                <td>{{$row->total_debtor}}</td>
                                <td>
                                    <a href="{{route('organizations_details',$row->id)}}" class="btn btn-xs btn-success"><i class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                            @php $count ++; @endphp
                        @endforeach
                        </tbody>
                    </table>
                </div>
{{--                <div class="text-center">--}}
{{--                    {!! $employees->appends(request()->except('page'))->links() !!}--}}
{{--                </div>--}}
            @else
                <h2 class="text-center">{{trans('main.no_records') }}</h2>
            @endif
            <div class="clearfix"></div>
        </div>
    </div>
@stop
