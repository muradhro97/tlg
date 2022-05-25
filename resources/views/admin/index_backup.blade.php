


@extends('admin.layouts.main')
@section('content')

    @inject('client','App\Client')
    @inject('bill','App\Bill')
    @inject('installment','App\Installment')

    <?php
    $clients = $client->count();
    $bills = $bill->count();
    $installments = $installment->count();
    $down_payments = (int) $bill->sum('down_payment');

    ?>
    <div class="row">
        <div class="col-lg-3">
            <div class="widget style1">
                <div class="row">
                    <div class="col-xs-4 text-center">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="col-xs-8 text-right">
                        <span> العملاء </span>
                        <h2 class="font-bold">{{$clients}}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="widget style1 navy-bg">
                <div class="row">
                    <div class="col-xs-4">
                        <i class="fa fa-tasks fa-5x"></i>
                    </div>
                    <div class="col-xs-8 text-right">
                        <span> الفواتير </span>
                        <h2 class="font-bold">{{$bills}}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="widget style1 lazur-bg">
                <div class="row">
                    <div class="col-xs-4">
                        <i class="fa fa-tasks fa-5x"></i>
                    </div>
                    <div class="col-xs-8 text-right">
                        <span>الاقساط</span>
                        <h2 class="font-bold">{{$installments}}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="widget style1 yellow-bg">
                <div class="row">
                    <div class="col-xs-4">
                        <i class="fa fa-tasks7885
                         fa-5x"></i>
                    </div>
                    <div class="col-xs-8 text-right">
                        <span> المقدمات </span>
                        <h2 class="font-bold">{{$down_payments}}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div id="full-calendar"></div>
        </div>
    </div>
    @push('style')

        <link href="{{asset('assets/admin/plugins/fullcalendar/fullcalendar.min.css')}}" rel='stylesheet' />
        <link href="{{asset('assets/admin/plugins/fullcalendar/fullcalendar.print.min.css')}}" rel='stylesheet' media='print' />
    @endpush
    @push('script')


        <script src="{{asset('assets/admin/plugins/fullcalendar/lib/moment.min.js')}}"></script>
        {{--<script src="{{asset('assets/fullcalendar/lib/jquery.min.js')}}"></script>--}}
        <script src="{{asset('assets/admin/plugins/fullcalendar/fullcalendar.min.js')}}"></script>
        <script src="{{asset('assets/admin/plugins/fullcalendar/locale-all.js')}}"></script>

        <script>


            // start system calendar

            full_calendar = $('#full-calendar').fullCalendar({
                /*height: 650,*/
                displayEventTime: false,
                header: {
//                    left: 'prev,next today',
                    center: 'title',
                    //right: 'month,agendaWeek,agendaDay',
                    right: 'month,agendaWeek,agendaDay',
                },
//                dayNamesShort: ['الأحد', 'الأثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'],
                monthNames: ['يناير', 'فبراير', 'مارس', 'إبريل', 'مايو', 'يونيو', 'يوليو', 'اغسطس', 'سبتمبر', 'اكتوبر', 'فبراير', 'ديسمبر'],
                selectable: true,
                selectHelper: true,
                select: function (start, end, allDay) {
                    bootbox.prompt("Event name?", function (result) {
                        if (result === null) {

                        } else {

                            full_calendar.fullCalendar('renderEvent',
                                {
                                    title: result,
                                    start: start,
                                    end: end,
                                },
                                true // make the event "stick"
                            );
                        }
                        full_calendar.fullCalendar('unselect');
                    });
                },
                editable: false,
                events: "{{url('admin/dates')}}",
                locale: 'ar',
                isRTL: true,



                // eventDragStart: eventDragStart,
                /*events: "json-events.php",*/
                loading: function (bool) {
                    if (bool) $('#loading').show();
                    else $('#loading').hide();
                }


            });

            // end calender
        </script>
    @endpush
@stop


