<style>

    .navbar-top-links .dropdown-messages, .navbar-top-links .dropdown-tasks, .navbar-top-links .dropdown-alerts {
        width: 500px;
        min-width: 0;
    }
</style>
<a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
    <i class="fa fa-bell"></i> <span class="label label-primary">@if($notification_count >0){{$notification_count}}@endif</span>
</a>
<ul class="dropdown-menu dropdown-alerts">
    @if($notifications->count()>0)
        @foreach($notifications as $notification)
            <li class=" @if($notification->read_at== null)  bg-muted @endif">
                <a href="{{url($notification->data['link'].'?notification='.$notification->id)}}">
                    <div>
                        <i class="fa fa-bell-o  fa-fw "></i>  {{$notification->data['message']}}
                        <span class="pull-right text-muted small">{{$notification->created_at->diffForHumans()}}</span>
                    </div>
                </a>
            </li>
            <li class="divider"></li>
        @endforeach
            <li>
                <div class="text-center link-block">
                    <a href="{{url('admin/notification')}}">
                        <strong>{{trans('main.show_all_notifications')}}  </strong>
                        <i class="fa fa-angle-double-right"></i>
                    </a>
                </div>
            </li>
            <li>
                <div class="text-center link-block">
                    <a href="{{url('admin/read_all-notification')}}">
                        <strong>{{trans('main.mark_all_as_read')}}  </strong>
                        <i class="fa fa-eye"></i>
                    </a>
                </div>
            </li>
        @else


        <li>
            <div class="text-center link-block">

                <strong>{{trans('main.no_notifications')}}  </strong>

            </div>
        </li>
    @endif


</ul>
