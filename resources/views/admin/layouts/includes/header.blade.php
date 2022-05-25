<div class="row border-bottom">
    <nav class="navbar navbar-static-top " role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i>
            </a>

        </div>


        {{--<form class="navbar-form navbar-right  ">--}}
            {{--<div class="form-group">--}}

                {{--<div class="switch ">--}}
                    {{--<div class="onoffswitch">--}}
                        {{--<input type="checkbox" checked class="onoffswitch-checkbox" id="example1">--}}
                        {{--<label class="onoffswitch-label" for="example1">--}}
                            {{--<span class="onoffswitch-inner"></span>--}}
                            {{--<span class="onoffswitch-switch"></span>--}}
                        {{--</label>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}

        {{--</form>--}}

        <ul class="nav navbar-top-links navbar-right">

            <li  >
                @if(app()->getLocale()=="en")
                <a  href="{{url("admin/change-language?lang=ch")}}">
                    <i class="fa fa-globe"></i> Chinese
                </a>
                    @elseif(app()->getLocale()=="ch")
                    <a  href="{{url("admin/change-language?lang=en")}}">
                        <i class="fa fa-globe"></i> English
                    </a>
                @endif

            </li>

            <li class="dropdown">
                <a class=" count-info"  href="{{url('chat')}}" target="_blank">
                    <i class="fa fa-envelope"></i>  <span class="label label-warning">@if(auth()->user()->unread_messages >0){{auth()->user()->unread_messages}} @endif</span>
                </a>

            </li>


            <?php

            $notifications = auth()->user()->notifications->take(3);
//            dd($notifications);
            $notification_count = auth()->user()->unreadNotifications()->count();
            ?>
            <li class="dropdown notifications-area">

                @include('admin.notification.notifications')
                {{--<a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">--}}
                    {{--<i class="fa fa-bell"></i> <span class="label label-primary">@if($notification_count >0){{$notification_count}}@endif</span>--}}
                {{--</a>--}}
                {{--<ul class="dropdown-menu dropdown-alerts">--}}
                    {{--@if($notifications->count()>0)--}}
                        {{--@foreach($notifications as $notification)--}}
                            {{--<li class=" @if($notification->read_at== null)  bg-muted @endif">--}}
                                {{--<a href="{{url($notification->data['link'].'?notification='.$notification->id)}}">--}}
                                    {{--<div>--}}
                                        {{--<i class="fa fa-bell-o  fa-fw "></i>  {{$notification->data['message']}}--}}
                                        {{--<span class="pull-right text-muted small">{{$notification->created_at->diffForHumans()}}</span>--}}
                                    {{--</div>--}}
                                {{--</a>--}}
                            {{--</li>--}}
                            {{--<li class="divider"></li>--}}
                        {{--@endforeach--}}
                    {{--@endif--}}

                    {{--<li>--}}
                        {{--<div class="text-center link-block">--}}
                            {{--<a href="{{url('admin/notification')}}">--}}
                                {{--<strong>{{trans('main.show_all_notifications')}}  </strong>--}}
                                {{--<i class="fa fa-angle-double-right"></i>--}}
                            {{--</a>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            </li>

            <li>
                <a href="{{url('logout')}}">
                    <i class="fa fa-sign-out"></i> <span class="hidden-xs">{{trans('main.logout')}}</span>
                </a>
            </li>


        </ul>

    </nav>
</div>