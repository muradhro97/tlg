@section('breadcrumb')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>{{$title}} </h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{url('admin')}}">{{trans('main.home') }}</a>
                </li>
                <li class="active">
                    <a href="{{url('admin/'.$url)}}">
                        <strong>{{$title}}</strong>
                    </a>
                </li>
            </ol>
        </div>

    </div>
@stop
@section('title')
    {{$title}}
@stop