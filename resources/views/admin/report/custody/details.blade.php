@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.custody'),'url'=>'reports/custody'])
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
            <h5>{{trans('main.custody') }} | {{$employee->name}}</h5>
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


            @if($mergedRows->count()>0)
                <div class="table-responsive">
                    <table class="data-table table table-bordered myTable">
                        <thead>
                        <th>#</th>
                        <th>{{trans('main.creditor') }}</th>
                        <th>{{trans('main.debtor') }}</th>
                        <th>{{trans('main.details') }}</th>
                        <th>{{trans('main.date') }}</th>

                        </thead>
                        <tbody>
                        @php $count = 1; @endphp
                        @foreach($mergedRows as $index => $row)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{$row instanceof \App\Accounting ? $row->amount : '---'}}</td>
                                <td>{{$row instanceof \App\Payment ? $row->amount : '---'}}</td>
                                <td>{{$row->details}}</td>
                                <td>{{$row->date}}</td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <h2 class="text-center">{{trans('main.no_records') }}</h2>
            @endif
            <div class="clearfix"></div>
        </div>
    </div>

@stop
