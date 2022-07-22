@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.cash_in'),'url'=>'reports/cash_in'])
@stop
@section('content')
    @inject('project','App\Project')
    @inject('organization','App\Organization')

    <?php

    $projects = $project->oldest()->pluck('name', 'id')->toArray();
    $organizations = $organization->where('type','mainContractor')->oldest()->pluck('name', 'id')->toArray();

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
                    </div>
                </div>


                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="amount_from">{{trans('main.amount_from')}}</label>
                        <div class="input-group clockpicker" data-autoclose="true">
                            <input type="number" step="0.01" name="amount_from" class="form-control"
                                   placeholder="{{trans('main.amount_from')}}" value="{{ request()->amount_from}}">
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
                                   placeholder="{{trans('main.amount_to')}}" value="{{request()->amount_to}}">
                            <span class="input-group-addon">
                                <span class="fa fa-usd"></span>
                            </span>
                        </div>
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
            <h5>{{trans('main.cash_in') }}</h5>
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


                    <div class="row">
                        <div class="col-md-6">
                            <h4>{{trans('main.accounting_cash_in') }}</h4>

                            @if($funding_rows->count()>0)

                            <div class="table-responsive">

                                <table class="data-table table table-bordered myTable">
                                    <thead>
                                    <th>#</th>
                                    <th>{{trans('main.date') }}</th>
                                    <th>{{trans('main.project') }}</th>
                                    <th>{{trans('main.organization') }}</th>
                                    <th>{{trans('main.amount') }}</th>
                                    </thead>
                                    <tbody>
                                    @foreach($funding_rows as $row)
                                        <?php
                                        $iteration = $loop->iteration
                                        ?>
                                        <tr>
                                            <td><a href="{{url('/admin/accounting-cash-in/'.$row->id)}}"> {{$iteration}}</a></td>
                                                <td><a href="{{url('/admin/accounting-cash-in/'.$row->id)}}">{{$row->date}}</a></td>
                                                <td><a href="{{url('/admin/accounting-cash-in/'.$row->id)}}">{{$row->project->name}}</a></td>
                                                <td><a href="{{url('/admin/accounting-cash-in/'.$row->id)}}">{{$row->organization->name}}</a></td>
                                                <td><a href="{{url('/admin/accounting-cash-in/'.$row->id)}}">{{number_format($row->amount,2)}}</a></td>
                                            {{--                                <td>--}}
                                            {{--                                    <a href="{{route('cash_in_details',$row['id'])}}" class="btn btn-xs btn-success"><i class="fa fa-eye"></i></a>--}}
                                            {{--                                </td>--}}
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="4">{{trans('main.total')}}</td>
                                        <td>{{number_format($total_funding,2)}}</td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
    {{--                        <div class="text-center">--}}
    {{--                            {!! $funding_rows->appends(request()->except('page'))->links() !!}--}}
    {{--                        </div>--}}
                            @else
                                <h2 class="text-center">{{trans('main.no_records') }}</h2>
                            @endif
                            <div class="clearfix"></div>

                            <h4>{{trans('main.actual_cash_in') }}</h4>

                            @if($cash_in_rows->count()>0)

                                <div class="table-responsive">

                                    <table class="data-table table table-bordered myTable">
                                        <thead>
                                        <th>#</th>
                                        <th>{{trans('main.date') }}</th>
                                        <th>{{trans('main.project') }}</th>
                                        <th>{{trans('main.organization') }}</th>
                                        <th>{{trans('main.amount') }}</th>
                                        </thead>
                                        <tbody>
                                        @foreach($cash_in_rows as $row)
                                            <?php
                                            $iteration = $loop->iteration
                                            ?>
                                            <tr>
                                                <td><a href="{{url('/admin/accounting-cash-in/'.$row->id)}}"> {{$iteration}}</a></td>
                                                <td><a href="{{url('/admin/accounting-cash-in/'.$row->id)}}">{{$row->date}}</a></td>
                                                <td><a href="{{url('/admin/accounting-cash-in/'.$row->id)}}">{{$row->project->name}}</a></td>
                                                <td><a href="{{url('/admin/accounting-cash-in/'.$row->id)}}">{{$row->organization->name}}</a></td>
                                                <td><a href="{{url('/admin/accounting-cash-in/'.$row->id)}}">{{number_format($row->amount,2)}}</a></td>
                                                {{--                                <td>--}}
                                                {{--                                    <a href="{{route('cash_in_details',$row['id'])}}" class="btn btn-xs btn-success"><i class="fa fa-eye"></i></a>--}}
                                                {{--                                </td>--}}
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="4">{{trans('main.total')}}</td>
                                            <td>{{number_format($total_cash_in,2)}}</td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
    {{--                            <div class="text-center">--}}
    {{--                                {!! $cash_in_rows->appends(request()->except('page'))->links() !!}--}}
    {{--                            </div>--}}
                            @else
                                <h2 class="text-center">{{trans('main.no_records') }}</h2>
                            @endif
                            <div class="clearfix"></div>
                        </div>
                        <div class="col-md-6">
                            <h4>{{trans('main.cash_in_extracts') }}</h4>

                            @if($extract_rows->count()>0)

                                <div class="table-responsive">

                                    <table class="data-table table table-bordered myTable">
                                        <thead>
                                        <th>#</th>
                                        <th>{{trans('main.date') }}</th>
                                        <th>{{trans('main.project') }}</th>
                                        <th>{{trans('main.organization') }}</th>
                                        <th>{{trans('main.amount') }}</th>
                                        </thead>
                                        <tbody>
                                        @foreach($extract_rows as $row)
                                            <?php
                                            $iteration = $loop->iteration
                                            ?>
                                            <tr>
                                                <td><a href="{{url('/admin/extract/'.$row->id)}}"> {{$iteration}}</a></td>
                                                <td><a href="{{url('/admin/extract/'.$row->id)}}">{{$row->date}}</a></td>
                                                <td><a href="{{url('/admin/extract/'.$row->id)}}">{{$row->project->name}}</a></td>
                                                <td><a href="{{url('/admin/extract/'.$row->id)}}">{{$row->organization->name}}</a></td>
                                                <td><a href="{{url('/admin/extract/'.$row->id)}}">{{number_format($row->total,2)}}</a></td>
                                                {{--                                <td>--}}
                                                {{--                                    <a href="{{route('cash_in_details',$row['id'])}}" class="btn btn-xs btn-success"><i class="fa fa-eye"></i></a>--}}
                                                {{--                                </td>--}}
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4">{{trans('main.total')}}</td>
                                                <td>{{number_format($total_extracts,2)}}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
    {{--                            <div class="text-center">--}}
    {{--                                    {!! $extract_rows->appends(request()->except('page'))->links() !!}--}}
    {{--                            </div>--}}
                            @else
                                <h2 class="text-center">{{trans('main.no_records') }}</h2>
                            @endif
                            <div class="clearfix"></div>
                        </div>
                    </div>


        </div>
    </div>
@stop
