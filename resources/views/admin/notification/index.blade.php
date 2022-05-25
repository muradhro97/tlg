@extends('admin.layouts.main')

@section('breadcrumb')

    @include('admin.layouts.partials.breadcrumb',['title'=>trans('main.notifications'),'url'=>'notification'])
@stop
@section('content')
    <style>
        .notification-item {
            padding: 20px 25px;
            /*background: #ffffff;*/
            border-top: 1px solid #e7eaec;
        }

        .notification-unread-item {
            background-color: lightsteelblue;
        }
    </style>
    @if($rows->count()>0)
        @foreach($rows as $row)
            @if($row->read_at== null)
                <div class="notification-item  yellow-bg ">
                    <div class="row">
                        <div class="col-md-10">

                            <a href="{{url($row->data['link'].'?notification='.$row->id)}}" class="vote-title">
                                {{$row->data['message']}}
                            </a>
                            <div class="vote-info "  style=" color: #fff">
                                {{--<i class="fa fa-comments-o"></i> <a href="#">Comments (32)</a>--}}
                                <i class="fa fa-clock-o"></i>  {{$row->created_at->diffForHumans()}} ({{$row->created_at->toDayDateTimeString() }})
                                {{--<i class="fa fa-user"></i> <a href="#">Andrew Williams</a>--}}
                            </div>
                        </div>
                        <div class="col-md-2 ">
                            <div class="vote-icon">
                                <i class="fa fa-building-o"> </i>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($row->read_at!== null)
                <div class="notification-item ">
                    <div class="row">
                        <div class="col-md-10">

                            <a href="{{url($row->data['link'].'?notification='.$row->id)}}" class="vote-title">
                                {{$row->data['message']}}
                            </a>
                            <div class="vote-info ">
                                {{--<i class="fa fa-comments-o"></i> <a href="#">Comments (32)</a>--}}
                                <i class="fa fa-clock-o"></i>  {{$row->created_at->diffForHumans()}} ({{$row->created_at->toDayDateTimeString() }})
                                {{--<i class="fa fa-user"></i> <a href="#">Andrew Williams</a>--}}
                            </div>
                        </div>
                        <div class="col-md-2 ">
                            <div class="vote-icon">
                                <i class="fa fa-building-o"> </i>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
        <div class="text-center">
            {!! $rows->appends(request()->except('page'))->links() !!}
        </div>
    @else
        <h2 class="text-center">{{trans('main.no_records') }}</h2>
    @endif


@stop